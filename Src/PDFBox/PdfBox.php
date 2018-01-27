<?php

include 'pdfConverter.php';
include 'options.php';
include 'command.php';
/**
 * PDF converter implemention with PdfBox
 *
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright SGH informationstechnologie UGmbh 2011-2014
 * @category SGH
 * @package PdfBox
 *
 */
class PdfBox implements PdfConverter
{
    /**
     * @var string
     */
    protected $_pathToPdfBox = 'pdfbox-app-1.7.0.jar';
   
    /**
     * @var Options
     */
    protected $_options;
	
    /**
     * @var string
     */
    protected $_pdfFile;


    /* (non-PHPdoc)
     * @see SGH\PdfBox.PdfConverter::domFromPdfFile()
     */
    public function domFromPdfFile($filename, $saveToFile = null)
    {
        $dom = new \DOMDocument();
        $dom->loadHTML($this->htmlFromPdfFile($filename, $saveToFile));
        return $dom;
    }

    /* (non-PHPdoc)
     * @see SGH\PdfBox.PdfConverter::domFromPdfStream()
     */
    public function domFromPdfStream($content, $saveToFile = null)
    {
        $dom = new \DOMDocument();
        $dom->loadHTML($this->htmlFromPdfStream($content, $saveToFile));
        return $dom;
    }

    /* (non-PHPdoc)
     * @see SGH\PdfBox.PdfConverter::htmlFromPdfFile()
     */
    public function htmlFromPdfFile($filename, $saveToFile = null)
    {
        $command = $this->prepareCommand($filename, $saveToFile);
        $command->setAsHtml(true);
        return $this->execute($command);
    }

    /* (non-PHPdoc)
     * @see SGH\PdfBox.PdfConverter::htmlFromPdfStream()
     */
    public function htmlFromPdfStream($content, $saveToFile = null)
    {
        $temp = tempnam(sys_get_temp_dir(), 'pdfbox');
        file_put_contents($temp, $content);
        $command = $this->prepareCommand($temp, $saveToFile, true);
        $command->setAsHtml(true);
        return $this->execute($command);
    }

    /* (non-PHPdoc)
     * @see SGH\PdfBox.PdfConverter::textFromPdfFile()
     */
    public function textFromPdfFile($filename, $pageNumber, $saveToFile=null	)
    {
		$command = $this->prepareCommand($filename, $saveToFile);
        return $this->execute($command, $pageNumber);
    }

    /* (non-PHPdoc)
     * @see SGH\PdfBox.PdfConverter::textFromPdfStream()
     */
    public function textFromPdfStream($content, $saveToFile = null)
    {
        $temp = tempnam(sys_get_temp_dir(), 'pdfbox');
        file_put_contents($temp, $content);
        $command = $this->prepareCommand($temp, $saveToFile, true);
        return $this->execute($command);
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->resetOptions();
    }
    /**
     * Reset advanced options to default values
     *
     * @return \SGH\PdfBox\PdfBox
     */
    public function resetOptions()
    {
        $this->_options = new Options();
        return $this;
    }
    /**
     * Factory method for Command object
     *
     * @param string $filename   Path to input file
     * @param string $saveToFile Path to output file or null if file should not be saved
     * @param bool   $pdfIsTemp  True if given PDF is a temporary file. Default: false
     * @return \SGH\PdfBox\Command
     */
    protected function prepareCommand($filename, $saveToFile, $pdfIsTemp = false)
    {
        $resultIsTemp = false;
        $command = new Command();
        $command->setPdfFile($filename, $pdfIsTemp);
        if ($saveToFile === null) {
            $saveToFile = tempnam(sys_get_temp_dir(), 'pdfbox');
            $resultIsTemp = true;
        }
        $command->setTextFile($saveToFile, $resultIsTemp);
        return $command;
    }
    /**
     * Execute given Command object.
     *
     * @param Command $command
     * @throws \RuntimeException If PdfBox returns error exit code
     * @return string            The converted text or HTML as string
     */
    protected function execute(Command $command, $pageNumber)
    {
        $command->setJar($this->getPathToPdfBox());
		$_options_ref = new Options;
	    $this->_options = $_options_ref->setStartPage($pageNumber);
		$this->_options = $_options_ref->setEndPage($pageNumber);
		//print_r($this->_options);	
        $command->setOptions($this->_options);
		//print_r ((string)$command);
        exec((string) $command . ' 2>&1', $stdErr, $exitCode);
        if ($command->getPdfFileIsTemp()) {
            unlink($command->getPdfFile());
        }
        if ($exitCode > 0) {
			
            throw new \RuntimeException(join("\n", $stdErr), $exitCode);
        }
        $resultFile = $command->getTextFile();
		
        $result = file_get_contents($resultFile);
        if ($command->getTextFileIsTemp()) {
            unlink($resultFile);
        }
        return $result;
    }
    /**
     * Return configuration object
     *
     * @return \SGH\PdfBox\Options
     */
    public function getOptions()
    {
        return $this->_options;
    }
    /**
     * Return full path to PdfBox jar file
     *
     * @return string $_pathToPdfBox
     */
    public function getPathToPdfBox()
    {
        return $this->_pathToPdfBox;
    }

    /**
     * Set full path to PdfBox jar file
     *
     * @param string $_pathToPdfBox
     */
    public function setPathToPdfBox($_pathToPdfBox)
    {
        $this->_pathToPdfBox = $_pathToPdfBox;
    }

}