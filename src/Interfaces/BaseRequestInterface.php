<?php namespace BinshopsBlog\Interfaces;

interface BaseRequestInterface
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules();
}