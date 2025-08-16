<?php

namespace App\Contracts\Requests;

interface HasDataTransferObjectInterface
{
    public function toDto(): mixed;
}
