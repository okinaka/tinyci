<?php
namespace TinyCI;

interface Task
{
    public function setOption($option);

    public function execute();
}
