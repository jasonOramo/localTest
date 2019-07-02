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
