<?php

/**
 * Helpers functions
 */

/// ------------------------------------------------------------------------

if( ! function_exists('_is_valid'))
{
    /**
     * Verify if variable is valid
     *
     * @param  string   $var
     * @return boolean
     */
    function _is_valid($var)
    {
        if(empty($var) || is_null($var) || FALSE === $var)
            return FALSE;

        return TRUE;
    }
}

/// ------------------------------------------------------------------------

if ( ! function_exists('_log_die'))
{
    /**
     * Send the message to the PHP error log file
     * and kill the script
     *
     * @param  string $msg
     * @return void
     */
    function _log_die($msg)
    {
        error_log($msg);
        die($msg);
    }
}