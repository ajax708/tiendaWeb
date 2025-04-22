<?php
use PHPUnit\Framework\TestCase;

class SecondDemoTest extends TestCase
{
    /**
     * @dataProvider additionProvider
     */
    public function testAddition($a, $b, $expected): void
    {
        // Suma y compara con el valor esperado
        $this->assertSame($expected, $a + $b);
    }

    public function additionProvider(): array
    {
        return [
            'ambos cero'      => [0, 0, 0],
            'positivos'       => [2, 3, 5],
            'negativos'       => [-1, -2, -3],
            'mixto positivo'  => [5, -2, 3],
        ];
    }

    public function testJsonEncodingAndStructure(): void
    {
        $data = ['foo' => 'bar', 'baz' => 42];
        $json = json_encode($data);

        // Verifica que es JSON válido
        $this->assertJson($json);

        // Verifica contenido
        $decoded = json_decode($json, true);
        $this->assertArrayHasKey('foo', $decoded);
        $this->assertEquals('bar', $decoded['foo']);
        $this->assertEquals(42, $decoded['baz']);
    }
}
