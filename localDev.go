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
/**
 * Definition for singly-linked list.
 * type ListNode struct {
 *     Val int
 *     Next *ListNode
 * }
 */
 
func addTwoNumbers(l1 *ListNode, l2 *ListNode) *ListNode {
        var current ListNode;
    var nextL1, nextL2 *ListNode;
    var tempVal,nextVal,addVal,smallVal,largerLength,smallerLength int;
    var l1Vals,l2Vals,larger,smaller []int;
    var eleArr []ListNode;


	for nextL1 = l1; nextL1 != nil; nextL1 = nextL1.Next{
		l1Vals = append(l1Vals,nextL1.Val);
	}
	for nextL2 = l2; nextL2 != nil; nextL2 = nextL2.Next{
		l2Vals = append(l2Vals,nextL2.Val);
	}

    l1Length := len(l1Vals);
    l2Length := len(l2Vals);

    if(l1Length >= l2Length){
    	largerLength = l1Length;
    	smallerLength = l2Length;
    	larger = l1Vals;
    	smaller = l2Vals;
    }else{
    	largerLength = l2Length;
    	smallerLength = l1Length;
    	larger = l2Vals;
    	smaller = l1Vals;
    }

    for j:=0; j < largerLength; j++{
    	if(j < smallerLength){
    		smallVal = smaller[j];
    	}else{
    		smallVal = 0;
    	}
    	tempVal = larger[j] + smallVal + addVal;

		if(tempVal > 9){
			nextVal = tempVal % 10;
			addVal = 1;
		}else{
			nextVal = tempVal;
			addVal = 0;
		}
		current.Val = nextVal;
		eleArr = append(eleArr,current);
    }
    if(addVal != 0){
    	current.Val = 1;
    	eleArr[len(eleArr) -1].Next = &current;
    	eleArr = append(eleArr,current);
    }
    for i :=0; i < len(eleArr) -1; i = i+1{
    	eleArr[i].Next = &eleArr[i+1];
    }

    return &eleArr[0];
}
func main(){
  
}
