<?php

namespace RewardCloud\Api;


class DigitalCode extends ApiGeneral
{

    /**
     * @param  array  $params
     *
     * @return array
     */
    public function issue(array $params)
    {
        $uri = 'digital/issue';

        $request = $this->postJson($uri, $params);

        return $request;
    }


    /**
     * @param  array  $params
     *
     * @return array
     */
    public function cancel(array $params)
    {
        $uri = 'digital/issue';

        $request = $this->deleteJson($uri, $params);

        return $request;
    }

    /**
     * @param  array  $params
     *
     * @return array
     */
    public function reverse(array $params)
    {
        $uri = 'digital/reverse';

        $request = $this->postJson($uri, $params);

        return $request;
    }

    /**
     * @param  array  $params
     *
     * @return array
     */
    public function checkBalance(array $params)
    {
        $uri = 'digital/check-balance';

        $request = $this->postJson($uri, $params);

        return $request;
    }

    /**
     * @param  array  $params
     *
     * @return array
     */
    public function checkStock(array $params)
    {
        $uri = 'check-stock';

        $request = $this->get($uri, $params);

        return $request;
    }


}