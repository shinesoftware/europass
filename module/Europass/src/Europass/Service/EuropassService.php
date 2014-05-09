<?php
namespace Europass\Service;


use Europass\Model\Data;

class EuropassService implements EuropassServiceInterface
{
	protected $data;
	protected $header;
	protected $locale;
	protected $acceptedLocale;
	protected $personaldata;
	protected $debug;
	protected $format;
	protected $command;
	protected $createdat;
	protected $updatedat;
	
	/**
	 * Class constructor
	 */
	public function __construct(\Europass\Model\XmlData $xmldata, \Europass\Model\Personaldata $pd)
	{
		$this->acceptedLocale = array('bg', 'es', 'cs', 'da', 'de', 'et'. 'el', 'en', 'fr', 'hr', 'is', 'it', 'lv', 'lt', 'hu', 'mt', 'nl', 'no', 'pl', 'pt', 'ro', 'sk', 'sl', 'fi', 'sv', 'tr');
		$this->setFormat('pdf');
		$this->setCommand('document/to/pdf-cv');
		$this->data = $xmldata;
		$this->personaldata = $pd;
	}
	
	/**
	 * @return the $personaldata
	 */
	public function getPersonaldata() {
		return $this->personaldata;
	}

	/**
	 * @param field_type $personaldata
	 */
	public function setPersonaldata(\Europass\Model\Personaldata $personaldata) {
		$this->personaldata = $personaldata;
	}

	/**
	 * @return the $createdat
	 */
	public function getCreatedat() {
		return $this->createdat;
	}

	/**
	 * @return the $updatedat
	 */
	public function getUpdatedat() {
		return $this->updatedat;
	}

	/**
	 * @param field_type $createdat
	 */
	public function setCreatedat($createdat) {
		$this->createdat = $createdat;
	}

	/**
	 * @param field_type $updatedat
	 */
	public function setUpdatedat($updatedat) {
		$this->updatedat = $updatedat;
	}

	/**
	 * @return the $format
	 */
	public function getFormat() {
		return $this->format;
	}

	/**
	 * @return the $command
	 */
	public function getCommand() {
		return $this->command;
	}

	/**
	 * @param field_type $format
	 */
	public function setFormat($format) {
	 	if (! empty($format)) {
            $this->format = $format;
            if ($format == "pdf") {
                $this->setCommand('document/to/pdf');
            } elseif ($format == "doc") {
                $this->setCommand('document/to/word');
            } elseif ($format == "odt") {
                $this->setCommand('document/to/opendoc');
            } elseif ($format == "json") {
                $this->setCommand('document/to/json');
            } elseif ($format == "xml") {
                $this->setDebug(true);
                $format = "xml";
            }
            
            // Set the header of the content
            $this->setHeader($format);
        }
	}
	
	/*
	 * Return the header of the page 
	 */
	public function getHeader(){
		return $this->header;
	}

	/**
	 * Set the header of the response
	 * @param unknown_type $format
	 */
	private function setHeader ($format)
	{
	
		if ($format == "pdf") {
			$this->header = 'Content-Type: application/pdf;';
		} elseif ($format == "doc") {
			$this->header = 'Content-Type: application/vnd.ms-word;';
			$this->header = 'Content-Disposition: attachment; filename="cv.docx"';
		} elseif ($format == "odt") {
			$this->header = 'Content-Type: application/vnd.oasis.opendocument.text;';
			$this->header = 'Content-Disposition: attachment; filename="cv.odt"';
		} elseif ($format == "json") {
			$this->header = 'Content-Type: text/plain;';
		} elseif ($format == "xml") {
			$this->header = 'Content-Type: text/xml;';
		}
	}
	
	
	/**
	 * Set the Document information for the XML
	 *
	 * @return \SimpleXMLElement
	 */
	private function setDocumentInfo ()
	{
		$xml = $this->getData();
	
		$DocumentInfo = $xml->addChild('DocumentInfo');
	
		$createdat = !empty($this->createdat) ? str_replace(" ", "T", $this->createdat) . "Z" : date('Y-m-d') . "T" . date('H:i:s') . "Z";
        $updatedat = !empty($this->updatedat) ? str_replace(" ", "T", $this->updatedat) . "Z" : date('Y-m-d') . "T" . date('H:i:s') . "Z";
        
		$DocumentInfo->addChild('DocumentType', 'ECV_ESP');
		$DocumentInfo->addChild('CreationDate', $createdat);
		$DocumentInfo->addChild('LastUpdateDate', $updatedat);
	
		$DocumentInfo->addChild('XSDVersion', 'V3.1');
		$DocumentInfo->addChild('Generator', 'EuroCv.eu');
		$DocumentInfo->addChild('Comment', 'EuroCv.eu');
	
		return $xml;
	}

	/**
	 * @param field_type $command
	 */
	public function setCommand($command) {
		$this->command = $command;
	}

	/**
	 * @return the $locale
	 */
	public function getLocale() {
		return $this->locale;
	}

	/**
	 * @param string $locale
	 */
	public function setLocale($locale) {
		if(empty($locale) || !in_array($locale, $this->acceptedLocale)){
			$this->locale = "en";
		}else{
			$this->locale = $locale;
		}
		
		$this->data->addAttribute("locale", $this->locale);
	}

	
    /**
     * Get the xml data object 
     * (non-PHPdoc)
     * @see Europass\Service.EuropassServiceInterface::getData()
     */
    public function getData()
    {
        return $this->data;
    }
    
    
    /**
     * Create Identification section of the XML
     *
     * @return \SimpleXMLElement
     */
    private function createPersonaldata ()
    {
    	$user = $this->getPersonaldata();
    	$xml = $this->getData();
    	
    	$identification = $xml->addChild('LearnerInfo')->addChild('Identification');
    	$pd = $identification->addChild('PersonName');
    	 
    	$pd->addChild('FirstName', $user->getFirstname());
    	$pd->addChild('Surname', $user->getLastname());
    	
    	$contactInfo = $identification->addChild('ContactInfo');
    	$Demographics = $identification->addChild('Demographics');
    	
    	$birthdate = $user->getBirthdate();
    	if (! empty($birthdate)) {
    		list ($year, $month, $day) = explode('-', date('Y-m-d', strtotime($birthdate)));
    		$birthdateItem = $Demographics->addChild('Birthdate');
    		$birthdateItem->addAttribute('year', $year);
    		$birthdateItem->addAttribute('month', "--$month");
    		$birthdateItem->addAttribute('day', "---$day");
    	}
    	
    	$gender = $Demographics->addChild('Gender');
    	$gender->addChild('Code', $user->getGender());
    	$gender->addChild('Label', $user->getGender());
    }
    
    /**
     * Generate the file 
     * 
     * (non-PHPdoc)
     * @see Europass\Service.EuropassServiceInterface::generatePdf()
     */
    public function build()
    {
    	$data = $this->data;
    	$this->setDocumentInfo();
    	$this->createPersonaldata();
    	print_r($data);
    	die;
    	$apiUrl = "https://europass.cedefop.europa.eu/rest/v1/";
    	$apiUrl .= 'document/to/pdf';
    
    	$resume = $this->call('POST', $apiUrl, $data, $this->locale); // call API call method
    
    	if(strpos($resume, "exception")){
    		header('Content-Type: text/xml;');
    		print_r($resume);
    		die;
    	}
    
    	return $resume;
    }
    
    /**
     *
     * @param s: $method
     *            = POST, PUT, GET etc...
     *            : $data = array('param' => 'value') == api.php?param=value
     */
    protected function call ($method, $url, $data = false, $language = "en")
    {
    	$curl = curl_init();
    
    	switch ($method) {
    		case "POST":
    			curl_setopt($curl, CURLOPT_POST, 1);
    
    			if ($data) {
    				curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    			}
    			break;
    
    		case "PUT":
    			curl_setopt($curl, CURLOPT_PUT, 1);
    			break;
    		default:
    			if ($data) {
    				$url = sprintf("%s?%s", $url, http_build_query($data));
    			}
    	}
    
    	// Optional Authentication:
    	curl_setopt($curl, CURLOPT_HTTPHEADER, array (
    			'Content-Type: application/xml',
    			"Accept-Language: $language"
    	));
    
    	curl_setopt($curl, CURLOPT_URL, $url);
    	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    
    	return curl_exec($curl);
    }
    
}