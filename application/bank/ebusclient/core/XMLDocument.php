<?php
class XMLDocument
{
    private $iXMLString = '';


    public function getFirstTagName()
    {
        $tTagName = null;
        $tStartIndex = strpos($this->iXMLString, '<');
        $tEndIndex = strpos($this->iXMLString, '>');
        if ($tEndIndex > $tStartIndex)
        {
            $tTagName = substr($this->iXMLString, $tStartIndex + 1, $tEndIndex - ($tStartIndex + 1));
        }

        return $tTagName;
    }

    public function __construct($aXMLString='')
    {
        $this->init($aXMLString);
    }

    public function init($aXMLString)
    {
        $this->iXMLString = $aXMLString;
        return $this;
    }

    public function __toString()
    {
        return $this->iXMLString;
    }

    public function getValue($aTag)
    {
        $tXMLDocument = null;
        $tStartIndex = strpos($this->iXMLString, '<'.trim($aTag).'>');
        $tEndIndex = strpos($this->iXMLString, '</'.trim($aTag).'>');
        if (($tStartIndex !== FALSE) && ($tEndIndex !== FALSE) && ($tStartIndex < $tEndIndex))
        {
            $tXMLDocument = substr($this->iXMLString, $tStartIndex + strlen($aTag) + 2, $tEndIndex - ($tStartIndex + strlen($aTag) + 2));
        }
        return $tXMLDocument;
    }
    
    public function getValueNoNull($aTag)
    {
        $tValue = "";
        $tXML = $this->getValue($aTag);
        if ($tXML !== null)
        {
            $tValue = $tXML;
        }
        return $tValue;
    }

    public function getValueArray($aTag)
    {
        $tValues = array();
        $offset = 0;
        while(TRUE)
        {
            $tStartIndex = strpos($this->iXMLString, '<'.trim($aTag).'>', $offset);
            $tEndIndex = strpos($this->iXMLString, '</'.trim($aTag).'>', $offset);
            if (($tStartIndex === FALSE) || ($tEndIndex === FALSE) || ($tStartIndex > $tEndIndex))
            {
                break;
            }
            array_push($tValues, new XMLDocument(substr($this->iXMLString, $tStartIndex + strlen($aTag) + 2, $tEndIndex - ($tStartIndex + strlen($aTag) + 2))));
            $offset = $tEndIndex + 1;
        }
        return $tValues;
    }

    public function getValueArrayList($aTag)
    {
        return $this->getValueArray($aTag);
    }

    public function getDocuments($aTag)
    {
        return $this->getValueArray($aTag);
    }
    
    public function getFormatDocument($aSpace)
    {
        return $this->getFormatDocumentLevel(0, $aSpace);
    }


    private function getFormatDocumentLevel($aLevel, $aSpace)
    {
        $tSpace1 = str_repeat($aSpace, $aLevel + 1);
        $tTagName = $this->getFirstTagName();
        if ($tTagName === null)
        {
            return $this;
        }
        $tXMLString = "\n";
        $tXMLDocument = new XMLDocument($this->iXMLString);
        while (($tTagName = $tXMLDocument->getFirstTagName()) !== null)
        {
            $tTemp = $tXMLDocument->getValue($tTagName);
            $tSpace = "";
            
            if ($tTemp->getFirstTagName() !== null)
            {
                $tSpace = $tSpace1;
            }
            $tXMLString = "$tXMLString$tSpace1<$tTagName>".$tTemp->getFormatDocumentLevel($aLevel + 1, $aSpace)."$tSpace</$tTagName>\n";
            $tXMLDocument = $tXMLDocument->deleteFirstTagDocument();
                       
        }
        return new XMLDocument($tXMLString);
    }

    public function deleteFirstTagDocument()
    {
        $tTagName = $this->getFirstTagName();
        $tStartIndex = strpos($this->iXMLString, "<$tTagName>");
        $tEndIndex = strpos($this->iXMLString, "</$tTagName>");
        if ($tEndIndex > $tStartIndex)
        {
            $this->iXMLString = substr($this->iXMLString, $tEndIndex + strlen($tTagName) + 3);
            if ($this->iXMLString === FALSE)
            {
                $this->iXMLString = "";
            }
        }
        return $this;
    }

}

?>
