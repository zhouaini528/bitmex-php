<?php
namespace Lin\Bitmex\Api;

use Lin\Bitmex\Request;

class User extends Request
{
    public function get(array $data=[]){
        $this->type='GET';
        $this->path='/api/v1/user';
        
        return $this->exec();
    }
    
    public function getAffiliateStatus(array $data=[]){
        $this->type='GET';
        $this->path='/user/affiliateStatus';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function postCancelWithdrawal(array $data){
        $this->type='POST';
        $this->path='/user/cancelWithdrawal';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function getCheckReferralCode(array $data){
        $this->type='GET';
        $this->path='/user/checkReferralCode';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function getCommission(array $data){
        $this->type='GET';
        $this->path='/user/commission';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function postCommunicationToken(array $data){
        $this->type='POST';
        $this->path='/user/communicationToken';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function postConfirmEmail(array $data){
        $this->type='POST';
        $this->path='/user/confirmEmail';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function postConfirmWithdrawal(array $data){
        $this->type='POST';
        $this->path='/user/confirmWithdrawal';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function getDepositAddress(array $data=[]){
        $this->type='GET';
        $this->path='/user/depositAddress';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function getExecutionHistory(array $data=[]){
        $this->type='GET';
        $this->path='/user/executionHistory';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function postLogout(array $data=[]){
        $this->type='POST';
        $this->path='/user/logout';
        $this->data=$data;
        
        return $this->exec();
    }
    
    /**
     * 获取保证金余额
     * https://testnet.bitmex.com/api/v1/user/margin?currency=XBt
     * */
    public function getMargin(array $data=[]){
        $this->type='GET';
        $this->path='/api/v1/user/margin';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function getMinWithdrawalFee(array $data=[]){
        $this->type='GET';
        $this->path='/user/minWithdrawalFee';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function postPreferences(array $data)
    {
        $this->type='POST';
        $this->path='/user/preferences';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function postRequestWithdrawal(array $data)
    {
        $this->type='POST';
        $this->path='/user/requestWithdrawal';
        $this->data=$data;
        
        return $this->exec();
    }
    
    /**
     * 获取钱包余额
     * https://testnet.bitmex.com/api/v1/user/wallet?currency=XBt
     * */
    public function getWallet(array $data=[]){
        $this->type='GET';
        $this->path='/api/v1/user/wallet';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function getWalletHistory(array $data=[]){
        $this->type='GET';
        $this->path='/user/walletHistory';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function getWalletSummary(array $data=[]){
        $this->type='GET';
        $this->path='/user/walletSummary';
        $this->data=$data;
        
        return $this->exec();
    }
}