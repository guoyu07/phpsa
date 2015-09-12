<?php
/**
 * @author Patsura Dmitry https://github.com/ovr <talk@dmtry.me>
 */

namespace PHPSA;

use Ovr\PHPReflection\Types;
use RuntimeException;

class CompiledExpression
{
    /**
     * Unknown type
     */
    const UNKNOWN = Types::UNKNOWN_TYPE;

    /**
     * It's not unknown, It's unimplemented
     */
    const UNIMPLEMENTED = -100;

    /**
     * Void type
     */
    const VOID = Types::UNKNOWN_TYPE;

    const INTEGER = Types::INT_TYPE;

    /**
     * @deprectated
     */
    const LNUMBER = self::INTEGER;

    /**
     * Double/Float
     */
    const DOUBLE = Types::DOUBLE_TYPE;

    /**
     * Double/Float
     */
    const NUMBER = Types::NUMBER;

    /**
     * Double/Float
     * @deprectated
     */
    const DNUMBER = self::DOUBLE;

    /**
     * String
     */
    const STRING = Types::STRING_TYPE;

    /**
     * Boolean
     * true or false
     */
    const BOOLEAN = Types::BOOLEAN_TYPE;

    /**
     * Array
     */
    const ARR = Types::ARRAY_TYPE;

    /**
     * Object
     */
    const OBJECT = Types::OBJECT_TYPE;

    /**
     * Resource handler
     */
    const RESOURCE = Types::RESOURCE_TYPE;

    /**
     * Value is handled in variable
     */
    const VARIABLE = 512;

    /**
     * Resource handler
     */
    const NULL = Types::NULL_TYPE;

    /**
     * self::INT_TYPE | self::DOUBLE_TYPE | self::STRING_TYPE | self::BOOLEAN_TYPE | self::ARRAY_TYPE | self::RESOURCE_TYPE | self::OBJECT_TYPE | self::NULL_TYPE
     */
    const MIXED = Types::MIXED;

    /**
     * I can't explain what it's :D
     */
    const DYNAMIC = 10000;

    /**
     * By default we don't know what it is
     *
     * @var int
     */
    protected $type;

    /**
     * Possible value
     *
     * @var mixed
     */
    protected $value;


    /**
     * Construct new CompiledExpression to pass result
     *
     * @param int $type
     * @param null $value
     */
    public function __construct($type = self::UNKNOWN, $value = null)
    {
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param integer $value
     */
    public function isEquals($value)
    {
        return $this->value == $value;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return Variable
     */
    public function toVariable()
    {
        return new Variable($this->type, $this->value);
    }

    /**
     * If we don't know $type but know $value
     *
     * @param $value
     * @throws RuntimeException
     * @return CompiledExpression
     */
    public static function fromZvalValue($value)
    {
        $type = gettype($value);
        switch ($type) {
            case 'integer':
                return new CompiledExpression(self::LNUMBER, $value);
            case 'float':
            case 'double':
                return new CompiledExpression(self::DNUMBER, $value);
            case 'boolean':
                return new CompiledExpression(self::BOOLEAN, $value);
            case 'NULL':
                return new CompiledExpression(self::NULL, null);
        }

        throw new RuntimeException("Type '{$type}' is not supported");
    }

    /**
     * @return boolean
     */
    public function isCurrectTypeValue()
    {
        return true;
    }
}
