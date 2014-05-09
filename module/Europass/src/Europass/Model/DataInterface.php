<?php
namespace Europass\Model;

interface DataInterface
{
    public function getXml();
    public function setXml($xml);
    public function addCdata($cdata);
    public function as_formated_xml();
}