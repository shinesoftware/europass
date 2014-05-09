<?php
namespace Europass\Service;

interface EuropassServiceInterface
{
    /**
     * Should return the user PDF file
     *
     * @return file
     */
    public function build();
    public function getData();

}