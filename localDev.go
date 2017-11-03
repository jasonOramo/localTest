func reverse(x int) int {
    signValue := 1;
    if x < 0{
        signValue = -1;
    }
    deltaValue := x;
    resSlice := []int{};
    var res, in int;
    for deltaValue * signValue > 9{
        in = deltaValue % 10;
        deltaValue = deltaValue / 10;
        resSlice = append(resSlice,in);
    }
    resSlice = append(resSlice,deltaValue);
    iLength := len(resSlice);
    for i := 0; i < iLength; i = i+1 {
        res = res * 10 + resSlice[i];
    }
    var max = (1 << 31) - 1;
    if(res *signValue > max){
        return 0;
    }else{
        return res;
    }
}

func main(){
  
}
