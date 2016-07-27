<?php

namespace MbSupport;

use Illuminate\Contracts\Support\Jsonable;

/**
 * This is an empty class to add the Jsonable interface to the
 * ApiResponse class; when implementing in Laravel it takes
 * advantage of having the response application/json
 * response headers automatically created when
 * returning directly from controllers.
 */
class ApiResponseLaravel extends ApiResponse implements Jsonable
{}

/* End of file */
