<?php

namespace common\constants;

enum Status: int
{
    case ACTIVE = 10;
    case INACTIVE = 9;
    case DELETED = 0;
}
