<?php

namespace App;

enum ApprovalStatus:string
{
    case Pending = 'pending';
    case Approved = 'accepted';
    case Rejected = 'rejected';
}
