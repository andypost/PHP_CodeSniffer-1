<?php
/**
 * Tests for the \PHP_CodeSniffer\Files\File::getMemberProperties method.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace PHP_CodeSniffer\Tests\Core\File;

use PHP_CodeSniffer\Tests\Core\AbstractMethodUnitTest;

/**
 * Tests for the \PHP_CodeSniffer\Files\File::getMemberProperties method.
 *
 * @covers \PHP_CodeSniffer\Files\File::getMemberProperties
 */
class GetMemberPropertiesTest extends AbstractMethodUnitTest
{


    /**
     * Test the getMemberProperties() method.
     *
     * @param string                         $identifier Comment which precedes the test case.
     * @param array<string, string|int|bool> $expected   Expected function output.
     *
     * @dataProvider dataGetMemberProperties
     *
     * @return void
     */
    public function testGetMemberProperties($identifier, $expected)
    {
        $variable = $this->getTargetToken($identifier, T_VARIABLE);
        $result   = self::$phpcsFile->getMemberProperties($variable);

        // Unset those indexes which are not being tested.
        unset($result['type_token'], $result['type_end_token']);

        $this->assertSame($expected, $result);

    }//end testGetMemberProperties()


    /**
     * Data provider for the GetMemberProperties test.
     *
     * @see testGetMemberProperties()
     *
     * @return array<string, array<string|array<string, string|int|bool>>>
     */
    public function dataGetMemberProperties()
    {
        return [
            'var-modifier'                                                 => [
                'identifier' => '/* testVar */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => false,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => '',
                    'nullable_type'   => false,
                ],
            ],
            'var-modifier-and-type'                                        => [
                'identifier' => '/* testVarType */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => false,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => '?int',
                    'nullable_type'   => true,
                ],
            ],
            'public-modifier'                                              => [
                'identifier' => '/* testPublic */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => '',
                    'nullable_type'   => false,
                ],
            ],
            'public-modifier-and-type'                                     => [
                'identifier' => '/* testPublicType */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => 'string',
                    'nullable_type'   => false,
                ],
            ],
            'protected-modifier'                                           => [
                'identifier' => '/* testProtected */',
                'expected'   => [
                    'scope'           => 'protected',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => '',
                    'nullable_type'   => false,
                ],
            ],
            'protected-modifier-and-type'                                  => [
                'identifier' => '/* testProtectedType */',
                'expected'   => [
                    'scope'           => 'protected',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => 'bool',
                    'nullable_type'   => false,
                ],
            ],
            'private-modifier'                                             => [
                'identifier' => '/* testPrivate */',
                'expected'   => [
                    'scope'           => 'private',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => '',
                    'nullable_type'   => false,
                ],
            ],
            'private-modifier-and-type'                                    => [
                'identifier' => '/* testPrivateType */',
                'expected'   => [
                    'scope'           => 'private',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => 'array',
                    'nullable_type'   => false,
                ],
            ],
            'static-modifier'                                              => [
                'identifier' => '/* testStatic */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => false,
                    'is_static'       => true,
                    'is_readonly'     => false,
                    'type'            => '',
                    'nullable_type'   => false,
                ],
            ],
            'static-modifier-and-type'                                     => [
                'identifier' => '/* testStaticType */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => false,
                    'is_static'       => true,
                    'is_readonly'     => false,
                    'type'            => '?string',
                    'nullable_type'   => true,
                ],
            ],
            'static-and-var-modifier'                                      => [
                'identifier' => '/* testStaticVar */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => false,
                    'is_static'       => true,
                    'is_readonly'     => false,
                    'type'            => '',
                    'nullable_type'   => false,
                ],
            ],
            'var-and-static-modifier'                                      => [
                'identifier' => '/* testVarStatic */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => false,
                    'is_static'       => true,
                    'is_readonly'     => false,
                    'type'            => '',
                    'nullable_type'   => false,
                ],
            ],
            'public-static-modifiers'                                      => [
                'identifier' => '/* testPublicStatic */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => true,
                    'is_readonly'     => false,
                    'type'            => '',
                    'nullable_type'   => false,
                ],
            ],
            'protected-static-modifiers'                                   => [
                'identifier' => '/* testProtectedStatic */',
                'expected'   => [
                    'scope'           => 'protected',
                    'scope_specified' => true,
                    'is_static'       => true,
                    'is_readonly'     => false,
                    'type'            => '',
                    'nullable_type'   => false,
                ],
            ],
            'private-static-modifiers'                                     => [
                'identifier' => '/* testPrivateStatic */',
                'expected'   => [
                    'scope'           => 'private',
                    'scope_specified' => true,
                    'is_static'       => true,
                    'is_readonly'     => false,
                    'type'            => '',
                    'nullable_type'   => false,
                ],
            ],
            'no-modifier'                                                  => [
                'identifier' => '/* testNoPrefix */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => false,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => '',
                    'nullable_type'   => false,
                ],
            ],
            'public-and-static-modifier-with-docblock'                     => [
                'identifier' => '/* testPublicStaticWithDocblock */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => true,
                    'is_readonly'     => false,
                    'type'            => '',
                    'nullable_type'   => false,
                ],
            ],
            'protected-and-static-modifier-with-docblock'                  => [
                'identifier' => '/* testProtectedStaticWithDocblock */',
                'expected'   => [
                    'scope'           => 'protected',
                    'scope_specified' => true,
                    'is_static'       => true,
                    'is_readonly'     => false,
                    'type'            => '',
                    'nullable_type'   => false,
                ],
            ],
            'private-and-static-modifier-with-docblock'                    => [
                'identifier' => '/* testPrivateStaticWithDocblock */',
                'expected'   => [
                    'scope'           => 'private',
                    'scope_specified' => true,
                    'is_static'       => true,
                    'is_readonly'     => false,
                    'type'            => '',
                    'nullable_type'   => false,
                ],
            ],
            'property-group-simple-type-prop-1'                            => [
                'identifier' => '/* testGroupType 1 */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => 'float',
                    'nullable_type'   => false,
                ],
            ],
            'property-group-simple-type-prop-2'                            => [
                'identifier' => '/* testGroupType 2 */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => 'float',
                    'nullable_type'   => false,
                ],
            ],
            'property-group-nullable-type-prop-1'                          => [
                'identifier' => '/* testGroupNullableType 1 */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => true,
                    'is_readonly'     => false,
                    'type'            => '?string',
                    'nullable_type'   => true,
                ],
            ],
            'property-group-nullable-type-prop-2'                          => [
                'identifier' => '/* testGroupNullableType 2 */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => true,
                    'is_readonly'     => false,
                    'type'            => '?string',
                    'nullable_type'   => true,
                ],
            ],
            'property-group-protected-static-prop-1'                       => [
                'identifier' => '/* testGroupProtectedStatic 1 */',
                'expected'   => [
                    'scope'           => 'protected',
                    'scope_specified' => true,
                    'is_static'       => true,
                    'is_readonly'     => false,
                    'type'            => '',
                    'nullable_type'   => false,
                ],
            ],
            'property-group-protected-static-prop-2'                       => [
                'identifier' => '/* testGroupProtectedStatic 2 */',
                'expected'   => [
                    'scope'           => 'protected',
                    'scope_specified' => true,
                    'is_static'       => true,
                    'is_readonly'     => false,
                    'type'            => '',
                    'nullable_type'   => false,
                ],
            ],
            'property-group-protected-static-prop-3'                       => [
                'identifier' => '/* testGroupProtectedStatic 3 */',
                'expected'   => [
                    'scope'           => 'protected',
                    'scope_specified' => true,
                    'is_static'       => true,
                    'is_readonly'     => false,
                    'type'            => '',
                    'nullable_type'   => false,
                ],
            ],
            'property-group-private-prop-1'                                => [
                'identifier' => '/* testGroupPrivate 1 */',
                'expected'   => [
                    'scope'           => 'private',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => '',
                    'nullable_type'   => false,
                ],
            ],
            'property-group-private-prop-2'                                => [
                'identifier' => '/* testGroupPrivate 2 */',
                'expected'   => [
                    'scope'           => 'private',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => '',
                    'nullable_type'   => false,
                ],
            ],
            'property-group-private-prop-3'                                => [
                'identifier' => '/* testGroupPrivate 3 */',
                'expected'   => [
                    'scope'           => 'private',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => '',
                    'nullable_type'   => false,
                ],
            ],
            'property-group-private-prop-4'                                => [
                'identifier' => '/* testGroupPrivate 4 */',
                'expected'   => [
                    'scope'           => 'private',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => '',
                    'nullable_type'   => false,
                ],
            ],
            'property-group-private-prop-5'                                => [
                'identifier' => '/* testGroupPrivate 5 */',
                'expected'   => [
                    'scope'           => 'private',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => '',
                    'nullable_type'   => false,
                ],
            ],
            'property-group-private-prop-6'                                => [
                'identifier' => '/* testGroupPrivate 6 */',
                'expected'   => [
                    'scope'           => 'private',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => '',
                    'nullable_type'   => false,
                ],
            ],
            'property-group-private-prop-7'                                => [
                'identifier' => '/* testGroupPrivate 7 */',
                'expected'   => [
                    'scope'           => 'private',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => '',
                    'nullable_type'   => false,
                ],
            ],
            'messy-nullable-type'                                          => [
                'identifier' => '/* testMessyNullableType */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => '?array',
                    'nullable_type'   => true,
                ],
            ],
            'fqn-type'                                                     => [
                'identifier' => '/* testNamespaceType */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => '\MyNamespace\MyClass',
                    'nullable_type'   => false,
                ],
            ],
            'nullable-classname-type'                                      => [
                'identifier' => '/* testNullableNamespaceType 1 */',
                'expected'   => [
                    'scope'           => 'private',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => '?ClassName',
                    'nullable_type'   => true,
                ],
            ],
            'nullable-namespace-relative-class-type'                       => [
                'identifier' => '/* testNullableNamespaceType 2 */',
                'expected'   => [
                    'scope'           => 'protected',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => '?Folder\ClassName',
                    'nullable_type'   => true,
                ],
            ],
            'multiline-namespaced-type'                                    => [
                'identifier' => '/* testMultilineNamespaceType */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => '\MyNamespace\MyClass\Foo',
                    'nullable_type'   => false,
                ],
            ],
            'property-after-method'                                        => [
                'identifier' => '/* testPropertyAfterMethod */',
                'expected'   => [
                    'scope'           => 'private',
                    'scope_specified' => true,
                    'is_static'       => true,
                    'is_readonly'     => false,
                    'type'            => '',
                    'nullable_type'   => false,
                ],
            ],
            'invalid-property-in-interface'                                => [
                'identifier' => '/* testInterfaceProperty */',
                'expected'   => [],
            ],
            'property-in-nested-class-1'                                   => [
                'identifier' => '/* testNestedProperty 1 */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => '',
                    'nullable_type'   => false,
                ],
            ],
            'property-in-nested-class-2'                                   => [
                'identifier' => '/* testNestedProperty 2 */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => '',
                    'nullable_type'   => false,
                ],
            ],
            'php8-mixed-type'                                              => [
                'identifier' => '/* testPHP8MixedTypeHint */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => true,
                    'is_readonly'     => false,
                    'type'            => 'miXed',
                    'nullable_type'   => false,
                ],
            ],
            'php8-nullable-mixed-type'                                     => [
                'identifier' => '/* testPHP8MixedTypeHintNullable */',
                'expected'   => [
                    'scope'           => 'private',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => '?mixed',
                    'nullable_type'   => true,
                ],
            ],
            'namespace-operator-type-declaration'                          => [
                'identifier' => '/* testNamespaceOperatorTypeHint */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => '?namespace\Name',
                    'nullable_type'   => true,
                ],
            ],
            'php8-union-types-simple'                                      => [
                'identifier' => '/* testPHP8UnionTypesSimple */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => 'int|float',
                    'nullable_type'   => false,
                ],
            ],
            'php8-union-types-two-classes'                                 => [
                'identifier' => '/* testPHP8UnionTypesTwoClasses */',
                'expected'   => [
                    'scope'           => 'private',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => 'MyClassA|\Package\MyClassB',
                    'nullable_type'   => false,
                ],
            ],
            'php8-union-types-all-base-types'                              => [
                'identifier' => '/* testPHP8UnionTypesAllBaseTypes */',
                'expected'   => [
                    'scope'           => 'protected',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => 'array|bool|int|float|NULL|object|string',
                    'nullable_type'   => false,
                ],
            ],
            'php8-union-types-all-pseudo-types'                            => [
                'identifier' => '/* testPHP8UnionTypesAllPseudoTypes */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => false,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => 'false|mixed|self|parent|iterable|Resource',
                    'nullable_type'   => false,
                ],
            ],
            'php8-union-types-illegal-types'                               => [
                'identifier' => '/* testPHP8UnionTypesIllegalTypes */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => 'callable|void',
                    'nullable_type'   => false,
                ],
            ],
            'php8-union-types-nullable'                                    => [
                'identifier' => '/* testPHP8UnionTypesNullable */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => '?int|float',
                    'nullable_type'   => true,
                ],
            ],
            'php8-union-types-pseudo-type-null'                            => [
                'identifier' => '/* testPHP8PseudoTypeNull */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => 'null',
                    'nullable_type'   => false,
                ],
            ],
            'php8-union-types-pseudo-type-false'                           => [
                'identifier' => '/* testPHP8PseudoTypeFalse */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => 'false',
                    'nullable_type'   => false,
                ],
            ],
            'php8-union-types-pseudo-type-false-and-bool'                  => [
                'identifier' => '/* testPHP8PseudoTypeFalseAndBool */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => 'bool|FALSE',
                    'nullable_type'   => false,
                ],
            ],
            'php8-union-types-object-and-class'                            => [
                'identifier' => '/* testPHP8ObjectAndClass */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => 'object|ClassName',
                    'nullable_type'   => false,
                ],
            ],
            'php8-union-types-pseudo-type-iterable-and-array'              => [
                'identifier' => '/* testPHP8PseudoTypeIterableAndArray */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => 'iterable|array|Traversable',
                    'nullable_type'   => false,
                ],
            ],
            'php8-union-types-duplicate-type-with-whitespace-and-comments' => [
                'identifier' => '/* testPHP8DuplicateTypeInUnionWhitespaceAndComment */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => 'int|string|INT',
                    'nullable_type'   => false,
                ],
            ],
            'php8.1-readonly-property'                                     => [
                'identifier' => '/* testPHP81Readonly */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => true,
                    'type'            => 'int',
                    'nullable_type'   => false,
                ],
            ],
            'php8.1-readonly-property-with-nullable-type'                  => [
                'identifier' => '/* testPHP81ReadonlyWithNullableType */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => true,
                    'type'            => '?array',
                    'nullable_type'   => true,
                ],
            ],
            'php8.1-readonly-property-with-union-type'                     => [
                'identifier' => '/* testPHP81ReadonlyWithUnionType */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => true,
                    'type'            => 'string|int',
                    'nullable_type'   => false,
                ],
            ],
            'php8.1-readonly-property-with-union-type-with-null'           => [
                'identifier' => '/* testPHP81ReadonlyWithUnionTypeWithNull */',
                'expected'   => [
                    'scope'           => 'protected',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => true,
                    'type'            => 'string|null',
                    'nullable_type'   => false,
                ],
            ],
            'php8.1-readonly-property-with-union-type-no-visibility'       => [
                'identifier' => '/* testPHP81OnlyReadonlyWithUnionType */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => false,
                    'is_static'       => false,
                    'is_readonly'     => true,
                    'type'            => 'string|int',
                    'nullable_type'   => false,
                ],
            ],
            'php8-property-with-single-attribute'                          => [
                'identifier' => '/* testPHP8PropertySingleAttribute */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => 'string',
                    'nullable_type'   => false,
                ],
            ],
            'php8-property-with-multiple-attributes'                       => [
                'identifier' => '/* testPHP8PropertyMultipleAttributes */',
                'expected'   => [
                    'scope'           => 'protected',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => '?int|float',
                    'nullable_type'   => true,
                ],
            ],
            'php8-property-with-multiline-attribute'                       => [
                'identifier' => '/* testPHP8PropertyMultilineAttribute */',
                'expected'   => [
                    'scope'           => 'private',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => 'mixed',
                    'nullable_type'   => false,
                ],
            ],
            'invalid-property-in-enum'                                     => [
                'identifier' => '/* testEnumProperty */',
                'expected'   => [],
            ],
            'php8.1-single-intersection-type'                              => [
                'identifier' => '/* testPHP81IntersectionTypes */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => 'Foo&Bar',
                    'nullable_type'   => false,
                ],
            ],
            'php8.1-multi-intersection-type'                               => [
                'identifier' => '/* testPHP81MoreIntersectionTypes */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => 'Foo&Bar&Baz',
                    'nullable_type'   => false,
                ],
            ],
            'php8.1-illegal-intersection-type'                             => [
                'identifier' => '/* testPHP81IllegalIntersectionTypes */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => 'int&string',
                    'nullable_type'   => false,
                ],
            ],
            'php8.1-nullable-intersection-type'                            => [
                'identifier' => '/* testPHP81NullableIntersectionType */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => '?Foo&Bar',
                    'nullable_type'   => true,
                ],
            ],
            'php8.2-pseudo-type-true'                                      => [
                'identifier' => '/* testPHP82PseudoTypeTrue */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => 'true',
                    'nullable_type'   => false,
                ],
            ],
            'php8.2-pseudo-type-true-nullable'                             => [
                'identifier' => '/* testPHP82NullablePseudoTypeTrue */',
                'expected'   => [
                    'scope'           => 'protected',
                    'scope_specified' => true,
                    'is_static'       => true,
                    'is_readonly'     => false,
                    'type'            => '?true',
                    'nullable_type'   => true,
                ],
            ],
            'php8.2-pseudo-type-true-in-union'                             => [
                'identifier' => '/* testPHP82PseudoTypeTrueInUnion */',
                'expected'   => [
                    'scope'           => 'private',
                    'scope_specified' => true,
                    'is_static'       => false,
                    'is_readonly'     => false,
                    'type'            => 'int|string|true',
                    'nullable_type'   => false,
                ],
            ],
            'php8.2-pseudo-type-invalid-true-false-union'                  => [
                'identifier' => '/* testPHP82PseudoTypeFalseAndTrue */',
                'expected'   => [
                    'scope'           => 'public',
                    'scope_specified' => false,
                    'is_static'       => false,
                    'is_readonly'     => true,
                    'type'            => 'true|FALSE',
                    'nullable_type'   => false,
                ],
            ],

        ];

    }//end dataGetMemberProperties()


    /**
     * Test receiving an expected exception when a non property is passed.
     *
     * @param string $identifier Comment which precedes the test case.
     *
     * @dataProvider dataNotClassProperty
     *
     * @return void
     */
    public function testNotClassPropertyException($identifier)
    {
        $this->expectRunTimeException('$stackPtr is not a class member var');

        $variable = $this->getTargetToken($identifier, T_VARIABLE);
        $result   = self::$phpcsFile->getMemberProperties($variable);

    }//end testNotClassPropertyException()


    /**
     * Data provider for the NotClassPropertyException test.
     *
     * @see testNotClassPropertyException()
     *
     * @return array<string, array<string>>
     */
    public function dataNotClassProperty()
    {
        return [
            'method parameter'                                       => ['/* testMethodParam */'],
            'variable import using global keyword'                   => ['/* testImportedGlobal */'],
            'function local variable'                                => ['/* testLocalVariable */'],
            'global variable'                                        => ['/* testGlobalVariable */'],
            'method parameter in anon class nested in ternary'       => ['/* testNestedMethodParam 1 */'],
            'method parameter in anon class nested in function call' => ['/* testNestedMethodParam 2 */'],
            'method parameter in enum'                               => ['/* testEnumMethodParamNotProperty */'],
        ];

    }//end dataNotClassProperty()


    /**
     * Test receiving an expected exception when a non variable is passed.
     *
     * @return void
     */
    public function testNotAVariableException()
    {
        $this->expectRunTimeException('$stackPtr must be of type T_VARIABLE');

        $next   = $this->getTargetToken('/* testNotAVariable */', T_RETURN);
        $result = self::$phpcsFile->getMemberProperties($next);

    }//end testNotAVariableException()


}//end class
