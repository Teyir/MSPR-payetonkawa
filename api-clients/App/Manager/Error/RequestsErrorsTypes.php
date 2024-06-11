<?php

namespace Clients\Manager\Error;

class RequestsErrorsTypes
{
    public const OVERLOAD_REQUEST = "OVERLOAD_REQUEST";
    public const NON_AUTHORIZED_REQUEST = "NON_AUTHORIZED_REQUEST";
    public const FORBIDDEN = "FORBIDDEN";
    public const INVALID_REQUEST = "INVALID_REQUEST";
    public const WRONG_PARAMS = "WRONG_PARAMS";
    public const INTERNAL_SERVER_ERROR = "INTERNAL_SERVER_ERROR";
    public const NOT_FOUND = "NOT_FOUND";
    public const CONTENT_ALREADY_EXIST = "CONTENT_ALREADY_EXIST";
    public const TOO_MANY_REQUESTS = "TOO_MANY_REQUESTS";
    public const PAGE_EXPIRED = "PAGE_EXPIRED";
}
