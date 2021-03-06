<?php namespace Rule\ApiWrapper\Api\V2\Customization;

use Rule\ApiWrapper\Api\Api;
use Rule\ApiWrapper\Client\Request;
use Rule\ApiWrapper\Client\Response;

use \InvalidArgumentException;

class Customization extends Api
{
    /**
     * Create fields.
     * 
     * @param array $fields Array of fields {@link https://rule.se/apidoc/#subscriber-fields-create-groups-and-fields-post}
     * @return array Response result
     * @throws \Exception
     */
    public function create(array $fields)
    {
        $this->assertValidFields($fields);

        $request = new Request('customizations');
        $request->setParams(['fields' => $fields]);

        $response = $this->client->post($request);

        $this->assertSuccessResponse($response);

        return $response->getData();
    }

    /**
     * Get groups.
     * 
     * @param integer $limit Limit of the results count
     * @return array Request result
     */
    public function getList($limit = 100)
    {
        $request = new Request('customizations');
        $request->setQuery(['limit' =>$limit]);

        $response = $this->client->get($request);

        $this->assertSuccessResponse($response);

        return $response->getData();
    }

    /**
     * Get group fields
     *
     * @param integer $id Id of the group
     * @return array Request result
     * @throws \Exception
     */
    public function get($id)
    {
        $request = new Request('customizations');
        $request->setIdParam(urlencode($id));

        $response = $this->client->get($request);

        $this->assertSuccessResponse($response);

        return $response->getData();
    }

    /**
     * Check if fields are valid
     * @param array $fields 
     * @throws InvalidArgumentException
     */
    private function assertValidFields($fields)
    {
        if(!isset($fields)) {
            throw new InvalidArgumentException("Fields are empty");
        }

        foreach($fields as $field) {
            if(count(explode('.', $field['key'])) != 2) {
                throw new InvalidArgumentException('Key has wrong format');
            }
        }
    }
}