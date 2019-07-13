'use strict'


function testString2Int(s){
//   if(s.length) > 1 {
//     var arr;
//     for(var i = 0; i < s.length; i++){
//       arr.push(i);
//     }
//     return arr.map(function(x){return s[i]*1;}).reduce(function(x,y){return x*10+y;});
//   }else if(s.length == 1){
//     return s[0]*1;
//   }
//   return null;
  return Array.prototype.map.call(s,function(x){return x*1;}).reduce(function(x,y){return x*10+y;});
}



//https://leetcode.com/problems/best-time-to-buy-and-sell-stock-iv/submissions/
var maxProfit =  function(k, prices){
	var res = 0;
	if(k > prices.length / 2){
		for(let i = 1; i < prices.length; i++){
			if(prices[i] - prices[i-1] > 0){
				res += prices[i] - prices[i-1];
			}
		}
		return res;
	}

	var own = new Array(prices.length);
	var clear = new Array(prices.length);
	own[0] = [];
	clear[0] = [];
	for(let i = 0; i < own.length; i++){
		for(let j = 0; j < k+1; j++){
			own[i] = own[i] || [];
			clear[i] = clear[i] || [];
			if(i == 0){
				own[0][j] = 0-prices[0];
			}else{
				own[i][j] = 0;
			}
			clear[i][j] = 0;
		}
	}
	for(var i = 1; i < prices.length; i++){
		for(var j = 1; j < k+1; j++){
			clear[i] = clear[i] || [];
			own[i] = own[i] || [];
			own[i][j] = Math.max(own[i-1][j], clear[i-1][j-1]-prices[i]);
			clear[i][j] = Math.max(own[i-1][j]+prices[i],clear[i-1][j]);
		}
	}
	return clear[prices.length -1][k];
};
//there is anothe way which I have no idea;
var maxProfitNew = function(k, prices) {
    if(k<=0||prices.length<=1)
        return 0;
    /*Max Profit on any number of transactions*/
    let mxPr = function(ar){
        let sum=0;
        for(let i=1;i<ar.length;i++)
            sum+=Math.max(0,ar[i]-ar[i-1]);
        return sum;
    }
    
    if(k>=prices.length)
        return mxPr(prices);
    
    
    let dp=new Array(2);
    dp[0]=new Array(prices.length).fill(0);
    let mxdif;
    for(let i=1;i<=k;i++){
        dp[1]=new Array(prices.length).fill(0);
        mxdif=0-prices[0];
        for(let j=1;j<prices.length;j++){
            dp[1][j]=Math.max(dp[1][j-1],mxdif+prices[j]);
            mxdif=Math.max(mxdif,dp[0][j]-prices[j]);
        }
        dp.shift();
    }
    return dp[dp.length-1].pop()||0;
};
