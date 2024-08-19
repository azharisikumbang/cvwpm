<?php

namespace Contracts\DTOs\Domain\Enum;


enum StatusPurchaseOrder: string
{
    case DRAFT = 'DRAFT';
    case WAITING_APPROVAL = 'WAITING_APPROVAL';
    case APPROVED = 'APPROVED';
    case REJECTED = 'REJECTED';
    case CANCELED = 'CANCELED';
    case ClOSED = 'CLOSED';
}