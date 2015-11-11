<?php

namespace DropboxTools;

# Include the Dropbox SDK libraries
require_once TL_ROOT . '/system/modules/dropbox_tools/vendor/dropbox-sdk-php/lib/Dropbox/autoload.php';
use \Dropbox as dbx;

class DropboxClient extends dbx\Client
{
    /** @var string */
    private $myApiHost;

    /*
     * constructor override because $apiHost property is private it can't be used here
     */
    function __construct($accessToken, $clientIdentifier, $userLocale = null)
    {
        parent::__construct($accessToken, $clientIdentifier, $userLocale);

        // The $host parameter is sort of internal.  We don't include it in the param list because
        // we don't want it to be included in the documentation.  Use PHP arg list hacks to get at
        // it.
        $host = null;
        if (\func_num_args() == 4) {
            $host = \func_get_arg(3);
            dbx\Host::checkArgOrNull("host", $host);
        }
        if ($host === null) {
            $host = dbx\Host::getDefault();
        }
        //$this->host = $host;

        // These fields are redundant, but it makes these values a little more convenient
        // to access.
        $this->myApiHost = $host->getApi();
        //$this->contentHost = $host->getContent();
    }

    function getMetadataSharedLink($path)
    {
        $params = array(
            "link" => $path
        );

        $response = $this->doGet(
            $this->myApiHost,
            "1/metadata/link",
            $params);

        if ($response->statusCode === 404) return null;
        if ($response->statusCode !== 200) throw dbx\RequestUtil::unexpectedStatus($response);

        $metadata = dbx\RequestUtil::parseResponseJson($response->body);
        if (array_key_exists("is_deleted", $metadata) && $metadata["is_deleted"]) return null;
        return $metadata;

//        return $this->_getMetadata('/link', array(
//            "list" => "true",
//            "link" => $path
//        ));
    }
}
