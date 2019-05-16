<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Bitmex;

use Lin\Bitmex\Api\Announcement;
use Lin\Bitmex\Api\ApiKey;
use Lin\Bitmex\Api\Chat;
use Lin\Bitmex\Api\Execution;
use Lin\Bitmex\Api\Funding;
use Lin\Bitmex\Api\GlobalNotification;
use Lin\Bitmex\Api\Instrument;
use Lin\Bitmex\Api\Insurance;
use Lin\Bitmex\Api\Leaderboard;
use Lin\Bitmex\Api\Liquidation;
use Lin\Bitmex\Api\Order;
use Lin\Bitmex\Api\OrderBook;
use Lin\Bitmex\Api\Position;
use Lin\Bitmex\Api\Quote;
use Lin\Bitmex\Api\Schema;
use Lin\Bitmex\Api\Settlement;
use Lin\Bitmex\Api\Stats;
use Lin\Bitmex\Api\User;
use Lin\Bitmex\Api\UserEvent;
use Lin\Bitmex\Api\Trade;

class Bitmex
{
    protected $key;
    protected $secret;
    protected $host;
    
    protected $proxy=false;
    
    function __construct(string $key='',string $secret='',string $host='https://www.bitmex.com'){
        $this->key=$key;
        $this->secret=$secret;
        $this->host=$host;
    }
    
    /**
     * 
     * */
    private function init(){
        return [
            'key'=>$this->key,
            'secret'=>$this->secret,
            'host'=>$this->host,
        ];
    }
    
    /**
     * Local development sets the proxy
     * @param bool|array
     * $proxy=false Default
     * $proxy=true  Local proxy http://127.0.0.1:12333
     * 
     * Manual proxy
     * $proxy=[
        'http'  => 'http://127.0.0.1:12333',
        'https' => 'http://127.0.0.1:12333',
        'no'    =>  ['.cn']
     * ]
     * */
    function setProxy($proxy=true){
        $this->proxy=$proxy;
    }
    
    /**
     * Public Announcements List Operations Expand Operations
     * */
    function announcement(){
        $announcement=new Announcement($this->init());
        $announcement->proxy($this->proxy);
        return $announcement;
    }
    
    /**
     * Persistent API Keys for Developers List Operations Expand Operations
     * */
    function apiKey(){
        $api_key= new ApiKey($this->init());
        $api_key->proxy($this->proxy);
        return $api_key;
    }
    
    /**
     * Trollbox Data List Operations Expand Operations
     * */
    function chat(){
        $chat= new Chat($this->init());
        $chat->proxy($this->proxy);
        return $chat;
    }
    
    /**
     * Raw Order and Balance Data List Operations Expand Operations
     * */
    function execution(){
        $execution= new Execution($this->init());
        $execution->proxy($this->proxy);
        return $execution;
    }
    
    /**
     * Swap Funding History List Operations Expand Operations
     * */
    function funding(){
        $funding= new Funding($this->init());
        $funding->proxy($this->proxy);
        return $funding;
    }
    
    /**
     * Account Notifications List Operations Expand Operations
     * */
    function globalNotification(){
        $global_notification= new GlobalNotification($this->init());
        $global_notification->proxy($this->proxy);
        return $global_notification;
    }
    
    /**
     * Tradeable Contracts, Indices, and History List Operations Expand Operations
     * */
    function instrument(){
        $instrument= new Instrument($this->init());
        $instrument->proxy($this->proxy);
        return $instrument;
    }
    
    /**
     *  Insurance Fund Data List Operations Expand Operations
     * */
    function insurance(){
        $insurance= new Insurance($this->init());
        $insurance->proxy($this->proxy);
        return $insurance;
    }
    
    /**
     *  Information on Top Users List Operations Expand Operations
     * */
    function leaderboard(){
        $leaderboard= new Leaderboard($this->init());
        $leaderboard->proxy($this->proxy);
        return $leaderboard;
    }
    
    /**
     *Active Liquidations List Operations Expand Operations
     * */
    function liquidation(){
        $liquidation= new Liquidation($this->init());
        $liquidation->proxy($this->proxy);
        return $liquidation;
    }
    
    /**
     *Placement, Cancellation, Amending, and History List Operations Expand Operations
     * */
    function order(){
        $order= new Order($this->init());
        $order->proxy($this->proxy);
        return $order;
    }
    
    /**
     *Level 2 Book Data List Operations Expand Operations
     * */
    function orderBook(){
        $order_book =new OrderBook($this->init());
        $order_book->proxy($this->proxy);
        return $order_book;
    }
    
    /**
     *Summary of Open and Closed Positions List Operations Expand Operations
     * */
    function position(){
        $position= new Position($this->init());
        $position->proxy($this->proxy);
        return $position;
    }
    
    /**
     *Best Bid/Offer Snapshots & Historical Bins List Operations Expand Operations
     * */
    function quote(){
        $quote= new Quote($this->init());
        $quote->proxy($this->proxy);
        return $quote;
    }
    
    /**
     *Dynamic Schemata for Developers List Operations Expand Operations
     * */
    function schema(){
        $schema= new Schema($this->init());
        $schema->proxy($this->proxy);
        return $schema;
    }
    
    /**
     *Historical Settlement Data List Operations Expand Operations
     * */
    function settlement(){
        $settlement= new Settlement($this->init());
        $settlement->proxy($this->proxy);
        return $settlement;
    }
    
    /**
     *Exchange Statistics List Operations Expand Operations
     * */
    function stats(){
        $stats= new Stats($this->init());
        $stats->proxy($this->proxy);
        return $stats;
    }
    
    /**
     *Individual & Bucketed Trades List Operations Expand Operations
     * */
    function trade(){
        $trade= new Trade($this->init());
        $trade->proxy($this->proxy);
        return $trade;
    }
    
    /**
     *Account Operations List Operations Expand Operations
     * */
    function user(){
        $user= new User($this->init());
        $user->proxy($this->proxy);
        return $user;
    }
    
    /**
     *User Events for auditing
     * */
    function userEvent(){
        $user_event =new UserEvent($this->init());
        $user_event->proxy($this->proxy);
        return $user_event;
    }
}