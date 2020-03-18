<?php

namespace RewardCloud\Api;


class PhysicalCard extends ApiGeneral
{

    /**
     * @param  array  $params
     *
     * @return array
     */
    public function activate(array $params)
    {
        $uri = 'physical/activate';

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
        $uri = 'physical/activate';

        $request = $this->deleteJson($uri, $params);

        return $request;
    }

    /**
     * @param  array  $params
     *
     * @return array
     */
    public function topUp(array $params)
    {
        $uri = 'physical/top-up';

        $request = $this->postJson($uri, $params);

        return $request;
    }

    /**
     * @param  array  $params
     *
     * @return array
     */
    public function topUpCancel(array $params)
    {
        $uri = 'physical/activate';

        $request = $this->deleteJson($uri, $params);

        return $request;
    }

    /**
     * @param  array  $params
     *
     * @return array
     */
    public function order(array $params)
    {
        $uri = 'physical/order-card';

        $request = $this->postJson($uri, $params);

        return $request;
    }

    /**
     * @param  array  $params
     *
     * @return array
     */
    public function orderStatus(array $params)
    {
        $uri = 'physical/order-status';

        $request = $this->postJson($uri, $params);

        return $request;
    }

    /**
     * @param  array  $params
     *
     * @return array
     */
    public function fulfil(array $params)
    {
        $uri = 'physical/fulfil-order';

        $request = $this->postJson($uri, $params);

        return $request;
    }

    /**
     * @param  array  $params
     *
     * @return array
     */
    public function balance(array $params)
    {
        $uri = 'physical/check-balance';

        $request = $this->postJson($uri, $params);

        return $request;
    }

}