<?php

namespace Atom\Xaml\Interfaces;

interface IDataContext
{
    public function setDataContext($context): void;
    public function getDataContext();
}
