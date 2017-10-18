import re

def findStr(testStr):
	oFile = open('abc.txt','r')
	result = {}
	findStr = '(?=' + testStr + ')'
	lineNum = 1
	for lineStr in iter(oFile):
		tempResult = [m.start() for m in re.finditer(findStr, lineStr)]
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
findStr('abc')