<?php

namespace Pitchart\Phunktional\Tests;

use function Pitchart\Phunktional\compose;
use Pitchart\Phunktional\Composition;
use function Pitchart\Phunktional\pipe;
use Pitchart\Phunktional\Pipeline;
use PHPUnit\Framework\TestCase;
use function Pitchart\Phunktional\Tests\Fixtures\plus_two;
use function Pitchart\Phunktional\Tests\Fixtures\square;

class PipelineTest extends TestCase
{
    public function test_is_instanciable_empty()
    {
        $pipeline = new Pipeline();
        self::assertInstanceOf(Pipeline::class, $pipeline);
    }

    public function test_is_instanciable_for_a_value()
    {
        $pipeline = new Pipeline('test');
        self::assertInstanceOf(Pipeline::class, $pipeline);
    }

    public function test_is_instanciable_with_a_value_and_a_composition_of_functions()
    {
        $pipeline = new Pipeline(3, new Composition(square(), plus_two()));
        self::assertInstanceOf(Pipeline::class, $pipeline);
    }

    public function test_permits_to_pipe_function_calls_on_a_value()
    {
        $result = (new Pipeline(4))
            ->bind(square())
            ->bind(plus_two())
            ->get()
        ;
        self::assertEquals(18, $result);
    }

    public function test_permits_to_pipe_function_calls_on_a_value_using_helper()
    {
        $result = pipe(4)
            ->bind(square())
            ->bind(plus_two())
            ->get()
        ;
        self::assertEquals(18, $result);
    }

    /**
     * @param $value
     * @param $callable
     * @param $expected
     *
     * @dataProvider callableProvider
     */
    public function test_pipes_callables($value, $callable, $expected)
    {
        self::assertEquals($expected, pipe()->bind($callable)->process($value));
    }



    public function callableProvider()
    {
        $invokableSquare = new class {
            public function __invoke($value) {
                return $value * $value;
            }
        };
        $squareObject = new class {
            public function square($value) {
                return $value * $value;
            }
        };

        return [
            'closure' => [3, square(), 9],
            'php function' => [9, 'sqrt', 3],
            'invokable object' => [3, $invokableSquare, 9],
            'object methode' => [3, [$squareObject, 'square'], 9],
        ];
    }
}
