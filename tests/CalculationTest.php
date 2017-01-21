<?php


/**
 * Class CalculationTest
 */
class CalculationTest extends TestCase
{
    /**
     * ContactTest setUp().
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * ContactTest tearDown().
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @param $data
     * @param $expectedResponse
     * @param $expectedException
     * @param $assertMessage
     *
     * @dataProvider postCalculationsDataProvider
     */
    public function testCalculation($data, $expectedResponse, $expectedException, $assertMessage)
    {
        if ($expectedException) {
            $this->expectException($expectedException);
        }

        $response = $this->call('POST', route('calculator.getResult'), $data);
        $this->assertEquals($expectedResponse, $response->getContent(), sprintf($assertMessage));
    }

    /**
     * @return array
     */
    public function postCalculationsDataProvider()
    {
        return array(

            //Add two positive numbers
            array(
                'data' => $this->generateOperandsPostBody(),
                'expectedResponse' => 3,
                'expectedException' => null,
                'assertMessage' => 'Add two positive numbers',
            ),

            //Add two negative numbers
            array(
                'data' => $this->generateOperandsPostBody(array('firstOperand' => -1, 'secondOperand' => -1)),
                'expectedResponse' => -2,
                'expectedException' => null,
                'assertMessage' => 'Add two negative numbers',
            ),

            //Add one positive and one negative number
            array(
                'data' => $this->generateOperandsPostBody(array('firstOperand' => 1, 'secondOperand' => -1)),
                'expectedResponse' => 0,
                'expectedException' => null,
                'assertMessage' => 'Add one positive and one negative number',
            ),

            //Multiply one positive number and zero
            array(
                'data' => $this->generateOperandsPostBody(
                    array('firstOperand' => 1, 'secondOperand' => 0, 'operation' => 'multiply')
                ),
                'expectedResponse' => 0,
                'expectedException' => null,
                'assertMessage' => 'Add one positive and one negative number',
            ),

            //Divide one positive number and zero
            array(
                'data' => $this->generateOperandsPostBody(
                    array('firstOperand' => 1, 'secondOperand' => 0, 'operation' => 'divide')
                ),
                'expectedResponse' => 'Not a number',
                'expectedException' => null,
                'assertMessage' => 'Multiply one positive number and zero',
            ),

            //Use non existing operator between two numbers
            array(
                'data' => $this->generateOperandsPostBody(
                    array('firstOperand' => 1, 'secondOperand' => 0, 'operation' => 'notExisting')
                ),
                'expectedResponse' => 'Invalid operator supplied',
                'expectedException' => null,
                'assertMessage' => 'Use non existing operation between two numbers',
            ),
        );
    }

    /**
     * Helper generateOperandsPostBody
     *
     * @param array $replacingFields
     * @param null $unset
     * @return array
     */
    private function generateOperandsPostBody($replacingFields = array(), $unset = null)
    {
        $postBody = array(
            'firstOperand' => 1,
            'secondOperand' => 2,
            'operation' => "add",
        );

        if (!empty($replacingFields)) {

            foreach ($replacingFields as $index => $value) {
                $postBody[$index] = $value;
            }
        }

        if (!empty($unset)) {
            unset($postBody[$unset]);
        }

        return $postBody;
    }
}
