import re

def findStr(testStr):
	oFile = open('abc.txt','r')
	result = {}
	findStr = '(?=' + testStr + ')'
	lineNum = 1
	for lineStr in iter(oFile):
		#tempResult = [m.start() for m in re.finditer(findStr, lineStr)]
		## use startswith instead of re generator for easy understanding
		tempResult = [i for i in range(len(lineStr)) if lineStr.startswith(testStr,i)]
		if len(tempResult) > 0:
			result[lineNum] = tempResult
		lineNum += 1
	oFile.close()
	resultStr = ''
	for key in result:
		lineMatches = result[key]
		for matchNum in lineMatches:
			resultStr += str(key) + ',' + str(matchNum) + " "
	print resultStr
def reverse( x):
        """
        :type x: int
        :rtype: int
        """
        maxValue = (1<<31) -1
        res = 0;
        if x > 0:
            strV =  str(x)[::-1]
            res = int(strV)
        else:
            strV = str(x*-1)[::-1]
            res =  int(strV) * -1
        if res > maxValue or res < maxValue * -1:
            return 0
        else:
            return res;
findStr('abc')
#https://leetcode.com/problems/add-two-numbers/description/
class ListNode(object):
    def __init__(self, x):
        self.val = x
        self.next = None
class Solution(object):
    def addTwoNumbers(self, l1, l2):
        """
        :type l1: ListNode
        :type l2: ListNode
        :rtype: ListNode
        """
        l1Vals = []
        l2Vals = []
        result = []
        addVal = 0
        l1Node = l1
        l2Node = l2
        while l1Node is not None:
            l1Vals.append(l1Node.val)
            l1Node = l1Node.next
        while l2Node is not None:
            l2Vals.append(l2Node.val)
            l2Node = l2Node.next
        if(len(l1Vals) >= len(l2Vals)):
            largerLength = len(l1Vals)
            largerVals = l1Vals
            smallerLength = len(l2Vals)
            smallerVals = l2Vals
        else:
            largerLength = len(l2Vals)
            largerVals = l2Vals
            smallerLength = len(l1Vals)
            smallerVals = l1Vals
        for i in range(largerLength):
            if(i < smallerLength):
                smallerVal = smallerVals[i]
            else:
                smallerVal = 0
            tempVal = smallerVal + largerVals[i] + addVal
            if(tempVal > 9):
                currentNode = ListNode(tempVal % 10)
                addVal = 1
            else:
                currentNode = ListNode(tempVal)
                addVal = 0
            result.append(currentNode)
        if(addVal != 0):
            currentNode = ListNode(1)
            result.append(currentNode)
        for i in range(0, len(result)):
            result[i].next = result[i-1]
        return result
abc = Solution()
a = ListNode(2)
a.next = ListNode(4)
a.next.next = ListNode(3)
b = ListNode(5)
b.next = ListNode(6)
b.next.next = ListNode(4)
res = abc.addTwoNumbers(a,b)
print res[0].val,res[0].next.val

#https://leetcode.com/problems/generate-parentheses/description/
class Solution2(object):
    def generateParenthesis(self, n):
        """
        :type n: int
        :rtype: List[str]
        """
        result = []
        self._getParenthesis(n,n,"",result)
        return result
        
    def _getParenthesis(self,leftLNum,leftRNum,inputS,result):
        if leftLNum > leftRNum:
            return
        if leftRNum == 0 and leftLNum == 0:
            result.append(inputS)
            return
        if leftLNum > 0:
            self._getParenthesis(leftLNum -1, leftRNum,inputS+"(",result)
        if leftRNum > 0:
            self._getParenthesis(leftLNum, leftRNum -1,inputS+")",result)

#https://leetcode.com/problems/remove-element/description/
class SolutionRemove(object):
    def removeElement(self, nums, val):
        """
        :type nums: List[int]
        :type val: int
        :rtype: int
        """
        if len(nums) == 0:
            return 0
        i = len(nums) -1
        j = 0
        while j < i:
            if nums[i] == val :
                i = i - 1
            else:
                if nums[j] == val :
                    tempVal = nums[j]
                    nums[j] = nums[i]
                    nums[i] = tempVal
                    i = i -1
                    j = j + 1
                else:
                    j = j + 1
        if(nums[j] == val):
            return j
        else:
            return j + 1

#https://leetcode.com/problems/combination-sum/description/
class Solution(object):
    def combinationSum(self, candidates, target):
        """
        :type candidates: List[int]
        :type target: int
        :rtype: List[List[int]]
        """
        result = []
        candidates = sorted(candidates)
        self._getCombi(result,[],candidates,0,target)
        return result
    def _getCombi(self,result,tempVals,nums,fromIndex,reminder):
        if reminder == 0:
            result.append(tempVals[:])
            return
        elif reminder < 0:
            return
        else:
            for i in range(fromIndex,len(nums)):
                if(reminder - nums[i] < 0):
                    break;
                tempVals.append(nums[i])
                self._getCombi(result,tempVals, nums, i, reminder-nums[i])
                tempVals.pop()