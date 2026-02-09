<?php
/**
 * Copyright © Lyra Network.
 * This file is part of Hyvä Compatibility module for PayZen. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra.com/)
 * @copyright Lyra Network
 * @license   https://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

namespace Lyranetwork\PayzenHyva\Model\Method;

/**
 * Virtual model for other method when payment option is selected.
 */
class Virtual extends \Lyranetwork\Payzen\Model\Method\Other
{
    protected $_code;
    protected $_title;
    protected $_id;

    public function __construct(String $code, String $title, String $id)
    {
        $this->_code = $code;
        $this->_title= $title;
        $this->_id= $id;
    }

    public function getCode()
    {
        return $this->_code;
    }

    public function getTitle()
    {
        return $this->_title;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setCode($code)
    {
        $this->_code = $code;
    }

    public function setTitle($title)
    {
        $this->_title = $title;
    }

    public function setId($id)
    {
        $this->_id = $id;
    }
}