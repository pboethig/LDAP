<?php
/**
 * This file is part of the phpDS package.
 *
 * (c) Chad Sikorra <Chad.Sikorra@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpDs\Ldap\Asn1\Type;

/**
 * Represents a Sequence type.
 *
 * @author Chad Sikorra <Chad.Sikorra@gmail.com>
 */
class SequenceType extends AbstractType implements ConstructedTypeInterface
{
    use ConstructedTypeTrait;

    /**
     * @var int
     */
    protected $tagNumber = self::TAG_TYPE_SEQUENCE;
}