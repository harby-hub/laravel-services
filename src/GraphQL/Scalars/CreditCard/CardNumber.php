<?php

namespace harby\services\GraphQL\Scalars\CreditCard;

use harby\services\Abstracts\Scalars\Texts;

class CardNumber extends Texts {

    public $name = "CardNumber" ;

    public string $type           ;
    public string $Creditcardname ;
    public string $brand          ;
    public string $card_number    ;
    public array  $number_length  ;
    public array  $cvc_length     ;
    public bool   $checksum_test  ;

    public int    $min  = 12           ;
    public int    $max  = 20           ;

    public array $available_cards = [
        // Firs debit cards
        'Dankort' => [
            'pattern'        => '/^5019/' ,
            'type'           => 'debit'   ,
            'Creditcardname' => 'dankort' ,
            'brand'          => 'Dankort' ,
            'number_length'  => [ 16 ]    ,
            'cvc_length'     => [ 3  ]    ,
            'checksum_test'  => true      ,
        ],
        'Forbrugsforeningen' => [
            'pattern'        => '/^600/'             ,
            'type'           => 'debit'              ,
            'Creditcardname' => 'forbrugsforeningen' ,
            'brand'          => 'Forbrugsforeningen' ,
            'number_length'  => [ 16 ]               ,
            'cvc_length'     => [ 3  ]               ,
            'checksum_test'  => true                 ,
        ],
        'Maestro' => [
            'pattern'        => '/^(5(018|0[235]|[678])|6(1|39|7|8|9))/'  ,
            'type'           => 'debit'                                   ,
            'Creditcardname' => 'maestro'                                 ,
            'brand'          => 'Maestro'                                 ,
            'number_length'  => [ 12 , 13 , 14 , 15 , 16 , 17 , 18 , 19 ] ,
            'cvc_length'     => [ 3 ]                                     ,
            'checksum_test'  => true                                      ,
        ],
        'VisaElectron' => [
            'pattern'        => '/^4(026|17500|405|508|844|91[37])/' ,
            'type'           => 'debit'                              ,
            'Creditcardname' => 'visaelectron'                       ,
            'brand'          => 'Visa Electron'                      ,
            'number_length'  => [ 16 , 17 ]                          ,
            'cvc_length'     => [ 3       ]                          ,
            'checksum_test'  => true                                 ,
        ],
        // Debit cards
        'AmericanExpress' => [
            'pattern'        => '/^3[47][0-9]/'    ,
            'type'           => 'credit'           ,
            'Creditcardname' => 'amex'             ,
            'brand'          => 'American Express' ,
            'number_length'  => [ 15 , 16 ]        ,
            'cvc_length'     => [ 3  , 4  ]        ,
            'checksum_test'  => true               ,
        ],
        'DinersClub' => [
            'pattern'        => '/^3(0[0-5]|[68][0-9])[0-9]/' ,
            'type'           => 'credit'                      ,
            'Creditcardname' => 'dinersclub'                  ,
            'brand'          => 'Diners Club International'   ,
            'number_length'  => [ 14 ]                        ,
            'cvc_length'     => [ 3  ]                        ,
            'checksum_test'  => true                          ,
        ],
        'Discovery' => [
            'pattern'        => '/^6(011|22126|22925|4[4-9]|5)/' ,
            'type'           => 'credit'                         ,
            'Creditcardname' => 'discover'                       ,
            'brand'          => 'Discover'                       ,
            'number_length'  => [ 16 ]                           ,
            'cvc_length'     => [ 3  ]                           ,
            'checksum_test'  => true                             ,
        ],
        'Jcb' => [
            'pattern'        => '/^(?:2131|1800|35\d{3})/' ,
            'type'           => 'credit'                   ,
            'Creditcardname' => 'jcb'                      ,
            'brand'          => 'JCB'                      ,
            'number_length'  => [ 16 , 17 , 18 , 19 ]      ,
            'cvc_length'     => [ 3                 ]      ,
            'checksum_test'  => true                       ,
        ],
        'Hipercard' => [
            'pattern'        => '/^(606282\d{10}(\d{3})?)|(3841\d{15})/' ,
            'type'           => 'credit'                                 ,
            'Creditcardname' => 'hipercard'                              ,
            'brand'          => 'Hipercard'                              ,
            'number_length'  => [ 13 , 16 , 19 ]                         ,
            'cvc_length'     => [ 3            ]                         ,
            'checksum_test'  => true                                     ,
        ],
        'Mastercard' => [
            'pattern'        => '/^(5[0-5]|2(2(2[1-9]|[3-9])|[3-6]|7(0|1|20)))/' ,
            'type'           => 'credit'                                         ,
            'Creditcardname' => 'mastercard'                                     ,
            'brand'          => 'Mastercard'                                     ,
            'number_length'  => [ 16 ]                                           ,
            'cvc_length'     => [ 3  ]                                           ,
            'checksum_test'  => true                                             ,
        ],
        'UnionPay' => [
            'pattern'        => '/^62(?!(2126|2925))/' ,
            'type'           => 'credit'               ,
            'Creditcardname' => 'unionpay'             ,
            'brand'          => 'Union Pay'            ,
            'number_length'  => [ 16 , 17 , 18 , 19 ]  ,
            'cvc_length'     => [ 3                  ] ,
            'checksum_test'  => true                   ,
        ],
        'Visa' => [
            'pattern'        => '/^4/'      ,
            'type'           => 'credit'    ,
            'Creditcardname' => 'visa'      ,
            'brand'          => 'Visa'      ,
            'number_length'  => [ 13 , 16 ] ,
            'cvc_length'     => [ 3       ] ,
            'checksum_test'  => true        ,
        ],
        'Mir' => [
            'pattern'        => '/^220/' ,
            'type'           => 'credit' ,
            'Creditcardname' => 'mir'    ,
            'brand'          => 'Mir'    ,
            'number_length'  => [ 16 ]   ,
            'cvc_length'     => [ 3  ]   ,
            'checksum_test'  => true     ,
        ],
        'Troy' => [
            'pattern'        => '/^9(?!(79200|79289))/' ,
            'type'           => 'credit'                ,
            'Creditcardname' => 'troy'                  ,
            'brand'          => 'Troy'                  ,
            'number_length'  => [ 16 ]                  ,
            'cvc_length'     => [ 3  ]                  ,
            'checksum_test'  => true                    ,
        ],
    ];

    public function checksumTest( ) : int {
        $checksum = 0 ;
        $len = strlen( $this -> card_number );
        for ( $i = 2 - ( $len % 2 ) ; $i <= $len ; $i += 2 ) $checksum += $this -> card_number[ $i - 1 ];
        // Analyze odd digits in even length strings or even digits in odd length strings.
        for ($i = $len % 2 + 1; $i < $len; $i += 2 ) {
            $digit     = $this -> card_number[ $i - 1 ] * 2 ;
            $checksum += ( $digit < 10 ) ? $digit : $digit - 9 ;
        }
        return ( $checksum % 10 ) === 0;
    }

    public function Factory( ) : void {
        foreach ( $this -> available_cards as $card ) if ( preg_match( $card[ 'pattern' ] , $this -> card_number ) ) {
            $this -> pattern        = $card[ 'pattern'        ] ;
            $this -> type           = $card[ 'type'           ] ;
            $this -> Creditcardname = $card[ 'Creditcardname' ] ;
            $this -> brand          = $card[ 'brand'          ] ;
            $this -> number_length  = $card[ 'number_length'  ] ;
            $this -> cvc_length     = $card[ 'cvc_length'     ] ;
            $this -> checksum_test  = $card[ 'checksum_test'  ] ;
        }
    }

    public function parseValue( $value ) : array {

        $this -> card_number = $value ;

        if ( is_null( $this -> card_number )                                     ) $this -> Error( "$this->name can not be null"                                 );
        if ( strlen ( $this -> card_number ) < $this -> min                      ) $this -> Error( "$this->name can not lower than : $this->min"                 );
        if ( strlen ( $this -> card_number ) > $this -> max                      ) $this -> Error( "$this->name can not greater than : $this->max"               );
        if ( ! is_numeric( preg_replace( '/\s+/' , '' , $this -> card_number ) ) ) $this -> Error( "Card number $this->card_number contains invalid characters"  );

       $this -> Factory( );

        if ( ! in_array( strlen( $this-> card_number ) , $this -> number_length ) ) $this -> Error( "Incorrect $this->card_number card length"                   );

        if ( ! ( ! $this -> checksum_test || $this -> checksumTest( ) )           ) $this -> Error( "Invalid card number: $this->card_number. Checksum is wrong" );

        return [
            'card_number'    => $this -> card_number    ,
            'type'           => $this -> type           ,
            'Creditcardname' => $this -> Creditcardname ,
            'brand'          => $this -> brand          ,
        ] ;
    }

}