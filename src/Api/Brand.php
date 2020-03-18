<?php

namespace RewardCloud\Api;


class Brand extends ApiGeneral
{

    /**
     * @param  array  $params
     *
     * @return array
     */
    public function list(array $params = [])
    {
        $uri = 'brands';

        $request = $this->get($uri, $params);

        return $request;
    }

    /**
     * @param  array  $params
     *
     * @return array
     */
    public function checkFloat(array $params = [])
    {
        $uri = 'check-floats';

        $request = $this->get($uri, $params);

        return $request;
    }

}