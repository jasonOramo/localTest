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
/**
*https://leetcode.com/problems/generate-parentheses/description/
*/
func generateParenthesis(n int) []string {
    res := [] string{};
    res = getValidRes(n,n,"",res);
    return res;
}

func getValidRes(leftL int, leftR int, inputStr string, res []string) [] string {
    if leftL > leftR {
        return res;
    }
    if leftL == 0 && leftR == 0 {
        res = append(res,inputStr);
        return res;
    }
    if leftL > 0{
        res = getValidRes(leftL -1 , leftR, inputStr + "(", res);
    }
    if leftR > 0{
        res = getValidRes(leftL , leftR -1, inputStr + ")", res);
    }
    return res;
}
func main(){
  
}

//https://leetcode.com/problems/remove-element/description/
func removeElement(nums []int, val int) int {
    if(len(nums) == 0){
        return 0;
    }
    i := len(nums) - 1
    j := 0
    for j < i {
        if nums[i] == val{
            i --;
        }else{
            if(nums[j] == val){
                tempVal := nums[i]
                nums[i] = nums[j]
                nums[j] = tempVal
                j++
                i--
            }else{
                j++
            }
        }
    }
    if nums[j] == val {
        return j
    }else{
        return j+1;
    }
}

//https://leetcode.com/problems/combination-sum/description/
func combinationSum(candicate []int, target int) [][]int{
    sort.Ints(candicate)
    var result [][]int
    if(len(candicate) == 0 ){
        return result;
    }else{
        tempResult := []int{}
         _getCombination(candicate, &result, tempResult,0,target)
    }
    return result

}

func _getCombination(nums []int, result *[][]int, tempResult []int, fromIndex int, currentTarget int){
    tempV := tempResult[:len(tempResult)]
    if(currentTarget == 0){
        tempR := []int{}
        for _, val := range tempV {
            tempR = append(tempR, val)
        }
        *result = append(*result,tempR)
    }else{
        if currentTarget > 0 {
            for i := fromIndex; i < len(nums); i++ {
                if(currentTarget - nums[i] < 0){
                    break;
                }
                tempV = append(tempV, nums[i])
                _getCombination(nums, result, tempV, i , currentTarget - nums[i])
                tempV = tempV[:len(tempV)-1]
            }
        }else{
            return
        }
    }
}