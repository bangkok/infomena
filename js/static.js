(function(){var chunker=/((?:\((?:\([^()]+\)|[^()]+)+\)|\[(?:\[[^\[\]]*\]|['"][^'"]*['"]|[^\[\]'"]+)+\]|\\.|[^ >+~,(\[\\]+)+|[>+~])(\s*,\s*)?((?:.|\r|\n)*)/g,done=0,toString=Object.prototype.toString,hasDuplicate=false,baseHasDuplicate=true;[0,0].sort(function(){baseHasDuplicate=false;return 0;});var Sizzle=function(selector,context,results,seed){results=results||[];context=context||document;var origContext=context;if(context.nodeType !==1&&context.nodeType !==9){return [];}
if(!selector||typeof selector !=="string"){return results;}
var parts=[],m,set,checkSet,extra,prune=true,contextXML=Sizzle.isXML(context),soFar=selector,ret,cur,pop,i;do{chunker.exec("");m=chunker.exec(soFar);if(m){soFar=m[3];parts.push(m[1]);if(m[2]){extra=m[3];break;}
}
}while(m);if(parts.length > 1&&origPOS.exec(selector)){if(parts.length ===2&&Expr.relative[ parts[0] ]){set=posProcess(parts[0]+parts[1],context);}else{set=Expr.relative[ parts[0] ] ?
[ context ]:
Sizzle(parts.shift(),context);while(parts.length){selector=parts.shift();if(Expr.relative[ selector ]){selector+=parts.shift();}
set=posProcess(selector,set);}
}
}else{if(!seed&&parts.length > 1&&context.nodeType ===9&&!contextXML &&
Expr.match.ID.test(parts[0])&& !Expr.match.ID.test(parts[parts.length-1])){ret=Sizzle.find(parts.shift(),context,contextXML);context=ret.expr ?Sizzle.filter(ret.expr,ret.set)[0]:ret.set[0];}
if(context){ret=seed ?
{ expr:parts.pop(),set:makeArray(seed)}:
Sizzle.find(parts.pop(),parts.length ===1 &&(parts[0] ==="~"||parts[0] ==="+")&& context.parentNode ?context.parentNode:context,contextXML);set=ret.expr ?Sizzle.filter(ret.expr,ret.set):ret.set;if(parts.length > 0){checkSet=makeArray(set);}else{prune=false;}
while(parts.length){cur=parts.pop();pop=cur;if(!Expr.relative[ cur ]){cur="";}else{pop=parts.pop();}
if(pop==null){pop=context;}
Expr.relative[ cur ](checkSet,pop,contextXML);}
}else{checkSet=parts=[];}
}
if(!checkSet){checkSet=set;}
if(!checkSet){Sizzle.error(cur||selector);}
if(toString.call(checkSet)==="[object Array]"){if(!prune){results.push.apply(results,checkSet);}else if(context&&context.nodeType ===1){for(i=0;checkSet[i]!=null;i++){if(checkSet[i] &&(checkSet[i] ===true||checkSet[i].nodeType ===1&&Sizzle.contains(context,checkSet[i]))){results.push(set[i]);}
}
}else{for(i=0;checkSet[i]!=null;i++){if(checkSet[i]&&checkSet[i].nodeType ===1){results.push(set[i]);}
}
}
}else{makeArray(checkSet,results);}
if(extra){Sizzle(extra,origContext,results,seed);Sizzle.uniqueSort(results);}
return results;};Sizzle.uniqueSort=function(results){if(sortOrder){hasDuplicate=baseHasDuplicate;results.sort(sortOrder);if(hasDuplicate){for(var i=1;i<results.length;i++){if(results[i] ===results[i-1]){results.splice(i--,1);}
}
}
}
return results;};Sizzle.matches=function(expr,set){return Sizzle(expr,null,null,set);};Sizzle.find=function(expr,context,isXML){var set;if(!expr){return [];}
for(var i=0,l=Expr.order.length;i<l;i++){var type=Expr.order[i],match;if((match=Expr.leftMatch[ type ].exec(expr))){var left=match[1];match.splice(1,1);if(left.substr(left.length-1)!=="\\"){match[1]=(match[1]||"").replace(/\\/g,"");set=Expr.find[ type ](match,context,isXML);if(set!=null){expr=expr.replace(Expr.match[ type ],"");break;}
}
}
}
if(!set){set=context.getElementsByTagName("*");}
return{set:set,expr:expr};};Sizzle.filter=function(expr,set,inplace,not){var old=expr,result=[],curLoop=set,match,anyFound,isXMLFilter=set&&set[0]&&Sizzle.isXML(set[0]);while(expr&&set.length){for(var type in Expr.filter){if((match=Expr.leftMatch[ type ].exec(expr))!= null&&match[2]){var filter=Expr.filter[ type ],found,item,left=match[1];anyFound=false;match.splice(1,1);if(left.substr(left.length-1)==="\\"){continue;}
if(curLoop ===result){result=[];}
if(Expr.preFilter[ type ]){match=Expr.preFilter[ type ](match,curLoop,inplace,result,not,isXMLFilter);if(!match){anyFound=found=true;}else if(match ===true){continue;}
}
if(match){for(var i=0;(item=curLoop[i])!= null;i++){if(item){found=filter(item,match,i,curLoop);var pass=not ^ !!found;if(inplace&&found!=null){if(pass){anyFound=true;}else{curLoop[i]=false;}
}else if(pass){result.push(item);anyFound=true;}
}
}
}
if(found !==undefined){if(!inplace){curLoop=result;}
expr=expr.replace(Expr.match[ type ],"");if(!anyFound){return [];}
break;}
}
}
if(expr ===old){if(anyFound==null){Sizzle.error(expr);}else{break;}
}
old=expr;}
return curLoop;};Sizzle.error=function(msg){throw "Syntax error,unrecognized expression:"+msg;};var Expr=Sizzle.selectors={order:[ "ID","NAME","TAG" ],match:{ID:/#((?:[\w\u00c0-\uFFFF\-]|\\.)+)/,CLASS:/\.((?:[\w\u00c0-\uFFFF\-]|\\.)+)/,NAME:/\[name=['"]*((?:[\w\u00c0-\uFFFF\-]|\\.)+)['"]*\]/,ATTR:/\[\s*((?:[\w\u00c0-\uFFFF\-]|\\.)+)\s*(?:(\S?=)\s*(['"]*)(.*?)\3|)\s*\]/,TAG:/^((?:[\w\u00c0-\uFFFF\*\-]|\\.)+)/,CHILD:/:(only|nth|last|first)-child(?:\((even|odd|[\dn+\-]*)\))?/,POS:/:(nth|eq|gt|lt|first|last|even|odd)(?:\((\d*)\))?(?=[^\-]|$)/,PSEUDO:/:((?:[\w\u00c0-\uFFFF\-]|\\.)+)(?:\((['"]?)((?:\([^\)]+\)|[^\(\)]*)+)\2\))?/
},leftMatch:{},attrMap:{"class":"className","for":"htmlFor"
},attrHandle:{href:function(elem){return elem.getAttribute("href");}
},relative:{"+":function(checkSet,part){var isPartStr=typeof part ==="string",isTag=isPartStr&&!/\W/.test(part),isPartStrNotTag=isPartStr&&!isTag;if(isTag){part=part.toLowerCase();}
for(var i=0,l=checkSet.length,elem;i<l;i++){if((elem=checkSet[i])){while((elem=elem.previousSibling)&& elem.nodeType !==1){}
checkSet[i]=isPartStrNotTag||elem&&elem.nodeName.toLowerCase()===part ?
elem||false:
elem ===part;}
}
if(isPartStrNotTag){Sizzle.filter(part,checkSet,true);}
},">":function(checkSet,part){var isPartStr=typeof part ==="string",elem,i=0,l=checkSet.length;if(isPartStr&&!/\W/.test(part)){part=part.toLowerCase();for(;i<l;i++){elem=checkSet[i];if(elem){var parent=elem.parentNode;checkSet[i]=parent.nodeName.toLowerCase()===part ?parent:false;}
}
}else{for(;i<l;i++){elem=checkSet[i];if(elem){checkSet[i]=isPartStr ?
elem.parentNode:
elem.parentNode ===part;}
}
if(isPartStr){Sizzle.filter(part,checkSet,true);}
}
},"":function(checkSet,part,isXML){var doneName=done++,checkFn=dirCheck,nodeCheck;if(typeof part ==="string"&&!/\W/.test(part)){part=part.toLowerCase();nodeCheck=part;checkFn=dirNodeCheck;}
checkFn("parentNode",part,doneName,checkSet,nodeCheck,isXML);},"~":function(checkSet,part,isXML){var doneName=done++,checkFn=dirCheck,nodeCheck;if(typeof part ==="string"&&!/\W/.test(part)){part=part.toLowerCase();nodeCheck=part;checkFn=dirNodeCheck;}
checkFn("previousSibling",part,doneName,checkSet,nodeCheck,isXML);}
},find:{ID:function(match,context,isXML){if(typeof context.getElementById !=="undefined"&&!isXML){var m=context.getElementById(match[1]);return m ?[m]:[];}
},NAME:function(match,context){if(typeof context.getElementsByName !=="undefined"){var ret=[],results=context.getElementsByName(match[1]);for(var i=0,l=results.length;i<l;i++){if(results[i].getAttribute("name")===match[1]){ret.push(results[i]);}
}
return ret.length ===0 ?null:ret;}
},TAG:function(match,context){return context.getElementsByTagName(match[1]);}
},preFilter:{CLASS:function(match,curLoop,inplace,result,not,isXML){match=" "+match[1].replace(/\\/g,"")+" ";if(isXML){return match;}
for(var i=0,elem;(elem=curLoop[i])!= null;i++){if(elem){if(not ^(elem.className &&(" "+elem.className+" ").replace(/[\t\n]/g," ").indexOf(match)>= 0)){if(!inplace){result.push(elem);}
}else if(inplace){curLoop[i]=false;}
}
}
return false;},ID:function(match){return match[1].replace(/\\/g,"");},TAG:function(match,curLoop){return match[1].toLowerCase();},CHILD:function(match){if(match[1] ==="nth"){var test=/(-?)(\d*)n((?:\+|-)?\d*)/.exec(match[2] ==="even"&&"2n"||match[2] ==="odd"&&"2n+1" ||
!/\D/.test(match[2])&& "0n+"+match[2]||match[2]);match[2]=(test[1]+(test[2]||1))-0;match[3]=test[3]-0;}
match[0]=done++;return match;},ATTR:function(match,curLoop,inplace,result,not,isXML){var name=match[1].replace(/\\/g,"");if(!isXML&&Expr.attrMap[name]){match[1]=Expr.attrMap[name];}
if(match[2] ==="~="){match[4]=" "+match[4]+" ";}
return match;},PSEUDO:function(match,curLoop,inplace,result,not){if(match[1] ==="not"){if((chunker.exec(match[3])|| "").length > 1||/^\w/.test(match[3])){match[3]=Sizzle(match[3],null,null,curLoop);}else{var ret=Sizzle.filter(match[3],curLoop,inplace,true ^ not);if(!inplace){result.push.apply(result,ret);}
return false;}
}else if(Expr.match.POS.test(match[0])|| Expr.match.CHILD.test(match[0])){return true;}
return match;},POS:function(match){match.unshift(true);return match;}
},filters:{enabled:function(elem){return elem.disabled ===false&&elem.type !=="hidden";},disabled:function(elem){return elem.disabled ===true;},checked:function(elem){return elem.checked ===true;},selected:function(elem){elem.parentNode.selectedIndex;return elem.selected ===true;},parent:function(elem){return !!elem.firstChild;},empty:function(elem){return !elem.firstChild;},has:function(elem,i,match){return !!Sizzle(match[3],elem).length;},header:function(elem){return(/h\d/i).test(elem.nodeName);},text:function(elem){return "text" ===elem.type;},radio:function(elem){return "radio" ===elem.type;},checkbox:function(elem){return "checkbox" ===elem.type;},file:function(elem){return "file" ===elem.type;},password:function(elem){return "password" ===elem.type;},submit:function(elem){return "submit" ===elem.type;},image:function(elem){return "image" ===elem.type;},reset:function(elem){return "reset" ===elem.type;},button:function(elem){return "button" ===elem.type||elem.nodeName.toLowerCase()==="button";},input:function(elem){return(/input|select|textarea|button/i).test(elem.nodeName);}
},setFilters:{first:function(elem,i){return i ===0;},last:function(elem,i,match,array){return i ===array.length-1;},even:function(elem,i){return i % 2 ===0;},odd:function(elem,i){return i % 2 ===1;},lt:function(elem,i,match){return i<match[3]-0;},gt:function(elem,i,match){return i > match[3]-0;},nth:function(elem,i,match){return match[3]-0 ===i;},eq:function(elem,i,match){return match[3]-0 ===i;}
},filter:{PSEUDO:function(elem,match,i,array){var name=match[1],filter=Expr.filters[ name ];if(filter){return filter(elem,i,match,array);}else if(name ==="contains"){return(elem.textContent||elem.innerText||Sizzle.getText([ elem ])|| "").indexOf(match[3])>= 0;}else if(name ==="not"){var not=match[3];for(var j=0,l=not.length;j<l;j++){if(not[j] ===elem){return false;}
}
return true;}else{Sizzle.error("Syntax error,unrecognized expression:"+name);}
},CHILD:function(elem,match){var type=match[1],node=elem;switch(type){case 'only':
case 'first':
while((node=node.previousSibling)){if(node.nodeType ===1){return false;}
}
if(type ==="first"){return true;}
node=elem;case 'last':
while((node=node.nextSibling)){if(node.nodeType ===1){return false;}
}
return true;case 'nth':
var first=match[2],last=match[3];if(first ===1&&last ===0){return true;}
var doneName=match[0],parent=elem.parentNode;if(parent &&(parent.sizcache !==doneName||!elem.nodeIndex)){var count=0;for(node=parent.firstChild;node;node=node.nextSibling){if(node.nodeType ===1){node.nodeIndex=++count;}
}
parent.sizcache=doneName;}
var diff=elem.nodeIndex-last;if(first ===0){return diff ===0;}else{return(diff % first ===0&&diff / first >= 0);}
}
},ID:function(elem,match){return elem.nodeType ===1&&elem.getAttribute("id")===match;},TAG:function(elem,match){return(match ==="*"&&elem.nodeType ===1)|| elem.nodeName.toLowerCase()===match;},CLASS:function(elem,match){return(" "+(elem.className||elem.getAttribute("class"))+" ")
.indexOf(match)> -1;},ATTR:function(elem,match){var name=match[1],result=Expr.attrHandle[ name ] ?
Expr.attrHandle[ name ](elem):
elem[ name ]!=null ?
elem[ name ]:
elem.getAttribute(name),value=result+"",type=match[2],check=match[4];return result==null ?
type ==="!=":
type ==="=" ?
value ===check:
type ==="*=" ?
value.indexOf(check)>= 0:
type ==="~=" ?
(" "+value+" ").indexOf(check)>= 0:
!check ?
value&&result !==false:
type ==="!=" ?
value !==check:
type ==="^=" ?
value.indexOf(check)===0:
type ==="$=" ?
value.substr(value.length-check.length)===check:
type ==="|=" ?
value ===check||value.substr(0,check.length+1)===check+"-":
false;},POS:function(elem,match,i,array){var name=match[2],filter=Expr.setFilters[ name ];if(filter){return filter(elem,i,match,array);}
}
}
};var origPOS=Expr.match.POS,fescape=function(all,num){return "\\"+(num-0+1);};for(var type in Expr.match){Expr.match[ type ]=new RegExp(Expr.match[ type ].source+(/(?![^\[]*\])(?![^\(]*\))/.source));Expr.leftMatch[ type ]=new RegExp(/(^(?:.|\r|\n)*?)/.source+Expr.match[ type ].source.replace(/\\(\d+)/g,fescape));}
var makeArray=function(array,results){array=Array.prototype.slice.call(array,0);if(results){results.push.apply(results,array);return results;}
return array;};try{Array.prototype.slice.call(document.documentElement.childNodes,0)[0].nodeType;}catch(e){makeArray=function(array,results){var ret=results||[],i=0;if(toString.call(array)==="[object Array]"){Array.prototype.push.apply(ret,array);}else{if(typeof array.length ==="number"){for(var l=array.length;i<l;i++){ret.push(array[i]);}
}else{for(;array[i];i++){ret.push(array[i]);}
}
}
return ret;};}
var sortOrder;if(document.documentElement.compareDocumentPosition){sortOrder=function(a,b){if(!a.compareDocumentPosition||!b.compareDocumentPosition){if(a==b){hasDuplicate=true;}
return a.compareDocumentPosition ?-1:1;}
var ret=a.compareDocumentPosition(b)& 4 ?-1:a ===b ?0:1;if(ret ===0){hasDuplicate=true;}
return ret;};}else if("sourceIndex" in document.documentElement){sortOrder=function(a,b){if(!a.sourceIndex||!b.sourceIndex){if(a==b){hasDuplicate=true;}
return a.sourceIndex ?-1:1;}
var ret=a.sourceIndex-b.sourceIndex;if(ret ===0){hasDuplicate=true;}
return ret;};}else if(document.createRange){sortOrder=function(a,b){if(!a.ownerDocument||!b.ownerDocument){if(a==b){hasDuplicate=true;}
return a.ownerDocument ?-1:1;}
var aRange=a.ownerDocument.createRange(),bRange=b.ownerDocument.createRange();aRange.setStart(a,0);aRange.setEnd(a,0);bRange.setStart(b,0);bRange.setEnd(b,0);var ret=aRange.compareBoundaryPoints(Range.START_TO_END,bRange);if(ret ===0){hasDuplicate=true;}
return ret;};}
Sizzle.getText=function(elems){var ret="",elem;for(var i=0;elems[i];i++){elem=elems[i];if(elem.nodeType ===3||elem.nodeType ===4){ret+=elem.nodeValue;}else if(elem.nodeType !==8){ret+=Sizzle.getText(elem.childNodes);}
}
return ret;};(function(){var form=document.createElement("div"),id="script"+(new Date()).getTime();form.innerHTML="<a name='"+id+"'/>";var root=document.documentElement;root.insertBefore(form,root.firstChild);if(document.getElementById(id)){Expr.find.ID=function(match,context,isXML){if(typeof context.getElementById !=="undefined"&&!isXML){var m=context.getElementById(match[1]);return m ?m.id ===match[1]||typeof m.getAttributeNode !=="undefined"&&m.getAttributeNode("id").nodeValue ===match[1] ?[m]:undefined:[];}
};Expr.filter.ID=function(elem,match){var node=typeof elem.getAttributeNode !=="undefined"&&elem.getAttributeNode("id");return elem.nodeType ===1&&node&&node.nodeValue ===match;};}
root.removeChild(form);root=form=null;
})();(function(){var div=document.createElement("div");div.appendChild(document.createComment(""));if(div.getElementsByTagName("*").length > 0){Expr.find.TAG=function(match,context){var results=context.getElementsByTagName(match[1]);if(match[1] ==="*"){var tmp=[];for(var i=0;results[i];i++){if(results[i].nodeType ===1){tmp.push(results[i]);}
}
results=tmp;}
return results;};}
div.innerHTML="<a href='#'></a>";if(div.firstChild&&typeof div.firstChild.getAttribute !=="undefined" &&
div.firstChild.getAttribute("href")!=="#"){Expr.attrHandle.href=function(elem){return elem.getAttribute("href",2);};}
div=null;
})();if(document.querySelectorAll){(function(){var oldSizzle=Sizzle,div=document.createElement("div");div.innerHTML="<p class='TEST'></p>";if(div.querySelectorAll&&div.querySelectorAll(".TEST").length ===0){return;}
Sizzle=function(query,context,extra,seed){context=context||document;if(!seed&&context.nodeType ===9&&!Sizzle.isXML(context)){try{return makeArray(context.querySelectorAll(query),extra);}catch(e){}
}
return oldSizzle(query,context,extra,seed);};for(var prop in oldSizzle){Sizzle[ prop ]=oldSizzle[ prop ];}
div=null;
})();}
(function(){var div=document.createElement("div");div.innerHTML="<div class='test e'></div><div class='test'></div>";if(!div.getElementsByClassName||div.getElementsByClassName("e").length ===0){return;}
div.lastChild.className="e";if(div.getElementsByClassName("e").length ===1){return;}
Expr.order.splice(1,0,"CLASS");Expr.find.CLASS=function(match,context,isXML){if(typeof context.getElementsByClassName !=="undefined"&&!isXML){return context.getElementsByClassName(match[1]);}
};div=null;
})();function dirNodeCheck(dir,cur,doneName,checkSet,nodeCheck,isXML){for(var i=0,l=checkSet.length;i<l;i++){var elem=checkSet[i];if(elem){elem=elem[dir];var match=false;while(elem){if(elem.sizcache ===doneName){match=checkSet[elem.sizset];break;}
if(elem.nodeType ===1&&!isXML){elem.sizcache=doneName;elem.sizset=i;}
if(elem.nodeName.toLowerCase()===cur){match=elem;break;}
elem=elem[dir];}
checkSet[i]=match;}
}
}
function dirCheck(dir,cur,doneName,checkSet,nodeCheck,isXML){for(var i=0,l=checkSet.length;i<l;i++){var elem=checkSet[i];if(elem){elem=elem[dir];var match=false;while(elem){if(elem.sizcache ===doneName){match=checkSet[elem.sizset];break;}
if(elem.nodeType ===1){if(!isXML){elem.sizcache=doneName;elem.sizset=i;}
if(typeof cur !=="string"){if(elem ===cur){match=true;break;}
}else if(Sizzle.filter(cur,[elem]).length > 0){match=elem;break;}
}
elem=elem[dir];}
checkSet[i]=match;}
}
}
Sizzle.contains=document.compareDocumentPosition ?function(a,b){return !!(a.compareDocumentPosition(b)& 16);}:function(a,b){return a !==b &&(a.contains ?a.contains(b):true);};Sizzle.isXML=function(elem){var documentElement=(elem ?elem.ownerDocument||elem:0).documentElement;return documentElement ?documentElement.nodeName !=="HTML":false;};var posProcess=function(selector,context){var tmpSet=[],later="",match,root=context.nodeType ?[context]:context;while((match=Expr.match.PSEUDO.exec(selector))){later+=match[0];selector=selector.replace(Expr.match.PSEUDO,"");}
selector=Expr.relative[selector] ?selector+"*":selector;for(var i=0,l=root.length;i<l;i++){Sizzle(selector,root[i],tmpSet);}
return Sizzle.filter(later,tmpSet);};window._=window.Sizzle=Sizzle;})();function $(id){return document.getElementById(id);}
if(typeof String.prototype.trim !=='function'){  String.prototype.trim=function(){    return this.replace(/^\s\s*/,'').replace(/\s\s*$/,'');}
}
if(!Array.indexOf){  Array.prototype.indexOf=function(obj){   for(var i=0;i<this.length;i++){    if(this[i]==obj){     return i;  }
  }
   return -1;}
}
function addStyleProperties(cssStr){var head=document.getElementsByTagName('head')[0];var styleSheets=head.getElementsByTagName('style');var styleSheet=null;if(styleSheets.length){styleSheet=styleSheets[styleSheets.length-1];}else{styleSheet=document.createElement("style");styleSheet.setAttribute("type","text/css");head.appendChild(styleSheet);}
if(styleSheet.styleSheet){ 
styleSheet.styleSheet.cssText=cssStr;}else{ 
styleSheet.appendChild(document.createTextNode(cssStr));}
}
function toInteger(str){return str.match(/\d+/g)[0];}
function dalert(msg){if($('dalert')){$('dalert').innerHTML+=msg+'<br />';}
}
function scrollPageTo(id){location.hash=id;}
function checkEvent(oEvt){oEvt=(oEvt)?oEvt:((window.event)?window.event:null);if(oEvt&&oEvt.srcElement&&!window.opera)
oEvt.target=oEvt.srcElement;return oEvt;}
function addEvent(objElement,strEventType,ptrEventFunc){if(objElement.addEventListener)
objElement.addEventListener(strEventType,ptrEventFunc,false);else if(objElement.attachEvent)
objElement.attachEvent('on'+strEventType,ptrEventFunc);}
function removeEvent(objElement,strEventType,ptrEventFunc){if(objElement.removeEventListener)objElement.removeEventListener(strEventType,ptrEventFunc,false);else if(objElement.detachEvent)objElement.detachEvent('on'+strEventType,ptrEventFunc);}
function switchClass(objNode,strCurrClass,strNewClass){if(matchClass(objNode,strNewClass))replaceClass(objNode,strCurrClass,strNewClass);else replaceClass(objNode,strNewClass,strCurrClass);}
var rclass=/[\n\t]/g,rspace=/\s+/;addRemoveClass=function(domNode,addClasses,removeClasses){var curClass=domNode.className;if(!curClass.length){if(!addClasses.length)return;domNode.className=addClasses.join("\x20");}else{var curClasses=curClass.split(rspace);var idx=-1;for(var i=0;i<removeClasses.length;i++){idx=curClasses.indexOf(removeClasses[i]);if(idx!=-1)curClasses[idx]='';}
for(var i=0;i<addClasses.length;i++){idx=curClasses.indexOf(addClasses[i]);if(idx!=-1)addClasses[i]='';}
var newClass=curClasses.length ?curClasses.join("\x20"):'';if(addClasses.length)newClass+=' '+addClasses.join("\x20");if(curClass!=newClass)domNode.className=newClass;}
}
function removeClass(objNode,strCurrClass){if(strCurrClass){var classNames=(strCurrClass).split(rspace);var className=(" "+objNode.className+" ").replace(rclass," ");for(var c=0,cl=classNames.length;c<cl;c++){className=className.replace(" "+classNames[c]+" "," ");}
objNode.className=className.trim();}else{objNode.className="";}
}
function addClass(objNode,strNewClass){replaceClass(objNode,strNewClass,'');if(!objNode.className){objNode.className=strNewClass;}else{var classNames=strNewClass.split(rspace);var className=" "+objNode.className+" ",setClass=objNode.className;for(var c=0,cl=classNames.length;c<cl;c++){if(className.indexOf(" "+classNames[c]+" ")< 0){setClass+=" "+classNames[c];}
}
objNode.className=setClass.trim();}
}
function replaceClass(objNode,strNewClass,strCurrClass){var strOldClass=strNewClass;if(strCurrClass&&strCurrClass.length){strCurrClass=strCurrClass.replace(/\s+(\S)/g,'|$1');if(strOldClass.length)strOldClass+='|';strOldClass+=strCurrClass;}
objNode.className=objNode.className.replace(new RegExp('(^|\\s+)('+strOldClass+')($|\\s+)','g'),'$1');objNode.className+=((objNode.className.length)?' ':'')+strNewClass;}
function matchClass(objNode,strCurrClass){return(objNode&&objNode.className.length&&objNode.className.match(new RegExp('(^|\\s+)('+strCurrClass+')($|\\s+)')));}
function getAncestorByClassName(oCurrentElement,sClassName,sTagName){var oCurrent=oCurrentElement.parentNode;while(oCurrent.parentNode){if(matchClass(oCurrent,sClassName)&&(!sTagName||oCurrent.tagName.toLowerCase()==sTagName.toLowerCase()))return oCurrent;oCurrent=oCurrent.parentNode;}
}
function getElementsByClassName(objParentNode,strNodeName,strClassName){var nodes=objParentNode.getElementsByTagName(strNodeName);if(!strClassName){return nodes;}
var nodesWithClassName=[];for(var i=0;i<nodes.length;i++){if(matchClass(nodes[i],strClassName)){nodesWithClassName[nodesWithClassName.length]=nodes[i];}
}
return nodesWithClassName;}
function getParentByClassName(element,className){var currentElement=element;while(currentElement.parentNode&&!matchClass(currentElement.parentNode,className)){currentElement=currentElement.parentNode;if(currentElement.tagName.toLowerCase()=='body'){return null;break;}
}
return currentElement.parentNode;}
function getParentByTagName(element,tagName){var currentElement=element;while(currentElement.parentNode&&currentElement.parentNode.tagName.toLowerCase()!= tagName){currentElement=currentElement.parentNode;if(currentElement.tagName.toLowerCase()=='body'){return null;break;}
}
return currentElement.parentNode;}
function getElementsByClassNameFirstLevel(objParentNode,strNodeName,strClassName){var nodes=objParentNode.getElementsByTagName(strNodeName);if(!strClassName){var nodesFirstLevel=[];for(var i=0;i<nodes.length;i++){var parent=getParentByTagName(nodes[i],strNodeName);var parentOfParent=getParentByTagName(objParentNode,strNodeName);if(!parent ||
parentOfParent&&parent==parentOfParent){nodesFirstLevel[nodesFirstLevel.length]=nodes[i];}
}
return nodesFirstLevel;}else{var nodesWithClassNameFirstLevel=[];for(var i=0;i<nodes.length;i++){var parent=getParentByClassName(nodes[i],strClassName);var parentOfParent=getParentByClassName(objParentNode,strClassName);if(matchClass(nodes[i],strClassName)&&
(!parent ||
(parentOfParent&&parent==parentOfParent)
)){nodesWithClassNameFirstLevel[nodesWithClassNameFirstLevel.length]=nodes[i];}
}
return nodesWithClassNameFirstLevel;}
}
function getPageY(oElement){var iPosY=oElement.offsetTop;while(oElement.offsetParent!=null){oElement=oElement.offsetParent;iPosY+=oElement.offsetTop;if(oElement.tagName=='BODY')break;}
return iPosY;}
function getPageX(oElement){var iPosX=oElement.offsetLeft;while(oElement.offsetParent!=null){oElement=oElement.offsetParent;iPosX+=oElement.offsetLeft;if(oElement.tagName=='BODY')break;}
return iPosX;}
function getMousePosition(e){if(e.pageX||e.pageY){var posX=e.pageX;var posY=e.pageY;}else if(e.clientX||e.clientY){var posX=e.clientX+document.body.scrollLeft+document.documentElement.scrollLeft;var posY=e.clientY+document.body.scrollTop+document.documentElement.scrollTop;}
return{x:posX,y:posY}
}
function createCookie(name,value,days){if(days){var date=new Date();date.setTime(date.getTime()+(days*24*60*60*1000));var expires=";expires="+date.toGMTString();}
else var expires="";document.cookie=name+"="+value+expires+";path=/";}
function readCookie(name){var nameEQ=name+"=";var ca=document.cookie.split(';');for(var i=0;i<ca.length;i++){var c=ca[i];while(c.charAt(0)==' ')c=c.substring(1,c.length);if(c.indexOf(nameEQ)==0)return c.substring(nameEQ.length,c.length);}
return null;}
function eraseCookie(name){createCookie(name,"",-1);}
function ajaxGet(url,ajaxCallBackFunction,params,callObject,ajaxCallBackErrorFunction){if(window.XMLHttpRequest){var ajaxObject=new XMLHttpRequest();ajaxObject.onreadystatechange=function(){ajaxHandler(ajaxObject,ajaxCallBackFunction,params,callObject,ajaxCallBackErrorFunction);};ajaxObject.open("GET",url,true);ajaxObject.send(null);}else if(window.ActiveXObject){var ajaxObject=new ActiveXObject("Microsoft.XMLHTTP");if(ajaxObject){ajaxObject.onreadystatechange=function(){ajaxHandler(ajaxObject,ajaxCallBackFunction,params,callObject,ajaxCallBackErrorFunction);};ajaxObject.open("GET",url,true);ajaxObject.send();}
}
}
function ajaxPost(url,data,ajaxCallBackFunction,params,callObject,ajaxCallBackErrorFunction){var ajaxObject=null;if(window.XMLHttpRequest){ 
ajaxObject=new XMLHttpRequest();}else if(window.ActiveXObject){ 
var ajaxObject=new ActiveXObject("Microsoft.XMLHTTP");}
if(ajaxObject){ajaxObject.onreadystatechange=function(){ajaxHandler(ajaxObject,ajaxCallBackFunction,params,callObject,ajaxCallBackErrorFunction);}
ajaxObject.open("POST",url,true);ajaxObject.setRequestHeader("Content-type","application/x-www-form-urlencoded");ajaxObject.setRequestHeader("Content-length",data.length);ajaxObject.setRequestHeader("Connection","close");ajaxObject.send(data);}
}
function ajaxHandler(ajaxObject,ajaxCallBackFunction,params,callObject,ajaxCallBackErrorFunction){if(ajaxObject.readyState==4){if(ajaxObject.status==200){ajaxCallBackFunction.call(callObject,ajaxObject,params);}else{if(ajaxCallBackErrorFunction){ajaxCallBackErrorFunction.call(callObject,ajaxObject);}else{alert("Возникла ошибка в получении XML данных:\n"+ajaxObject.statusText);}
}
}
}
Function.prototype.inheritsFrom=function(BaseClass){ 
var Inheritance=function(){};Inheritance.prototype=BaseClass.prototype;this.prototype=new Inheritance();this.prototype.constructor=this;this.superClass=BaseClass;}
if(!Function.prototype.call){ 
Function.prototype.call=function(){var oObject=arguments[0];var aArguments=[];var oResult;oObject.fFunction=this;for(var i=1;i<arguments.length;i++){aArguments[aArguments.length]='arguments['+i+']';}
eval('oResult=oObject.fFunction('+aArguments.join(',')+')');oObject.fFunction=null;return oResult;}
};Object.extendObject=function(destination,source){for(var property in source){destination[property]=source[property];}
return destination;};var ajaxFormClass=function(){this.ajaxUrls={save:'' 
};this.jsonResponse={error:{handler:'jsonResponseHandler_error'
},redirect:{handler:'jsonResponseHandler_redirect'
}
}
this.classNames={fieldHolder:'field_holder',
fieldData:'data',
fieldButton:'button',
fieldErrorMsgBox:'error_message',
fieldMarkedError:'error',
fieldMarkedChecked:'checked',
fieldMarkedAlert:'alert',
fieldIsRequired:'required',
fieldPass_1:'passfield_main',
fieldPass_2:'passfield_repeat',
isLoading:'loading',
unknownErrorHolder:'unknown_error_holder',
unknownErrorMsg:'unknown_error_msg' 
};this.errorMessages={fieldIsEmpty:'Вы не заполнили это поле',inputIsIncorrect:'Вы ввели недопустимый символ',inputIsInsufficient:'Вы ввели недостаточно символов',emailIsIncorrect:'Вы ввели недопустимый email',urlIsIncorrect:'Вы ввели недопустимый url',inputCharsNumberIsIncorrect:'Вы ввели неверное число букв',passwordIsShort:'Пароль слишком короткий',passwordsAreNotEqual:'Пароли не совпадают',unknownError:'Неопознанная ошибка',
fieldValueIsRepeated:'Кажется,вы добавили то же самое,что и раньше'
};}
Object.extendObject(ajaxFormClass.prototype,{getAjaxUrl:function(){return window.SITE_URL;},getErrorMsgBoxByField:function(field){var fieldHolder=getParentByClassName(field,this.classNames.fieldHolder);if(fieldHolder){var errorMsgBoxes=getElementsByClassName(fieldHolder,'*',this.classNames.fieldErrorMsgBox);if(errorMsgBoxes&&errorMsgBoxes.length){return errorMsgBoxes[0];}
}else{return null;}
},completeForm:function(redirectUrl){if(redirectUrl){window.location.href=redirectUrl;}else{window.location.href="/";}
},checkFormComplition:function(form){var formIsComplited=true;
var datas=getElementsByClassName(form,'*',this.classNames.fieldData);for(var i=0,length=datas.length;i<length;i++){fieldHolder=getParentByClassName(datas[i],this.classNames.fieldHolder);if((!datas[i].value.match(/\S/)&& 
matchClass(datas[i],this.classNames.fieldIsRequired))||
(datas[i].getAttribute('type')=='checkbox'&&
matchClass(datas[i],this.classNames.fieldIsRequired)&&
!datas[i].checked)
){formIsComplited=false;this.markField_error(datas[i],this.errorMessages.fieldIsEmpty);}else if((fieldHolder&&
matchClass(fieldHolder,this.classNames.fieldMarkedError))
){formIsComplited=false;}
}
return formIsComplited;},serializeForm:function(form){var data='';var datas=getElementsByClassName(form,'*',this.classNames.fieldData);for(var i=0,length=datas.length;i<length;i++){var type=datas[i].getAttribute('type');var param=datas[i].getAttribute('name');var value=datas[i].value;if(type=='radio'&&!datas[i].checked){continue;}
if(type=='checkbox'){value=datas[i].checked ?true:false;}else{value=datas[i].value;}
data+=(i!=0 ?'&':'')+param+'='+encodeURIComponent(value);}
return data;},sendData:function(sendDataType,form,fCheckFormComplition){if(!fCheckFormComplition&&!this.checkFormComplition(form)){return false;}else if(fCheckFormComplition&&!fCheckFormComplition(form)){alert('false');return false;}
var loadingClassName=this.classNames.isLoading;if(matchClass(form,loadingClassName)){return false;}
var url=this.getAjaxUrl(form);var params={form:form,loadingClassName:loadingClassName
};this.setLoading(params);if(sendDataType.toLowerCase()=='get'){var data=url+'?'+this.serializeForm(form);ajaxGet(data,this.sendDataOnload,params,this)
}else{var data=this.serializeForm(form);ajaxPost(url,data,this.sendDataOnload,params,this);}
return false;},sendDataOnload:function(ajaxObj,params){this.clearLoading(params);if(ajaxObj&&ajaxObj.responseText){var json=null
var errorServer=null;try{eval('json='+ajaxObj.responseText);}catch(e){alert('Произошла ошибка на сервере');errorServer=true;}
if(!errorServer){for(var prop in json){if(this.jsonResponse[prop].handler){this[this.jsonResponse[prop].handler](json,params);}
}
}
}
},checkData:function(field,params){var url=this.getAjaxUrl(field);var param=field.getAttribute('name');var value=field.value;var type=field.getAttribute('type');if(type=='checkbox'){value=field.checked ?true:false;}else{value=field.value;}
var data=param+'='+encodeURIComponent(value);var params=params ?params:{};Object.extendObject(params,{form:field.form,field:field
});this.setLoading(params);ajaxPost(url,data,this.sendDataOnload,params,this);},markField_clear:function(field){var fieldHolder=getParentByClassName(field,this.classNames.fieldHolder);if(fieldHolder){removeClass(fieldHolder,this.classNames.fieldMarkedError);removeClass(fieldHolder,this.classNames.fieldMarkedChecked);}
},markField_checked:function(field){var fieldHolder=getParentByClassName(field,this.classNames.fieldHolder);if(fieldHolder){this.markField_clear(field);addClass(fieldHolder,this.classNames.fieldMarkedChecked);}
},markField_error:function(field,errorMessage){var fieldHolder=getParentByClassName(field,this.classNames.fieldHolder);if(fieldHolder){this.markField_clear(field);addClass(fieldHolder,this.classNames.fieldMarkedError);var errorMsgBox=this.getErrorMsgBoxByField(field);if(errorMsgBox){errorMsgBox.innerHTML=errorMessage;}
}
},setLoading:function(params){if(params.field){var fieldParent=getParentByClassName(params.field,this.classNames.fieldHolder);if(fieldParent)addClass(fieldParent, this.classNames.isLoading);}else if(params.loadingClassName){addClass(params.form,params.loadingClassName);this.disableForm(params.form);}
},clearLoading:function(params){if(params.field){var fieldParent=getParentByClassName(params.field,this.classNames.fieldHolder);if(fieldParent)removeClass(fieldParent, this.classNames.isLoading);}else if(params.loadingClassName){removeClass(params.form,params.loadingClassName);this.enableForm(params.form);}
},disableForm:function(form){var formButtons=getElementsByClassName(form,'*',this.classNames.fieldButton);for(var i=0;i<formButtons.length;i++){formButtons[i].disabled=true;}
},enableForm:function(form){var formButtons=getElementsByClassName(form,'*',this.classNames.fieldButton);for(var i=0;i<formButtons.length;i++){formButtons[i].disabled=false;}
},showError:function(errorMsg){alert(errorMsg);},jsonResponseHandler_error:function(json,params){for(prop in json.error){if(typeof json.error[prop]!='string'){for(p in json.error[prop]){var fieldMarkedError=params.form[prop+'['+p+']'];var errorMessage=json.error[prop][p];if(fieldMarkedError){this.markField_error(fieldMarkedError,errorMessage);}
}
}else{var fieldMarkedError=params.form[prop];var errorMessage=json.error[prop];if(fieldMarkedError){this.markField_error(fieldMarkedError,errorMessage);}
}
}
},jsonResponseHandler_redirect:function(json,params){this.completeForm(json.redirect);}
});commentFormClass=function(){commentFormClass.superClass.apply(this,arguments);Object.extendObject(this.jsonResponse,{comments:{handler:'jsonResponseHandler_comments'
}
});this.currentUserClassName='';}
commentFormClass.inheritsFrom(ajaxFormClass);Object.extendObject(commentFormClass.prototype,{getAjaxUrl:function(form){var context=form.action.match(/context=([^&]+)/)[1];var url=''+window.SITE_URL+'ajax'+'/'+context+'/';return url;},postComment:function(postType,form){commentForm.sendData(postType,form);this.root_comments=null;return false;},getRootComments:function(){if(!this.root_comments){this.root_comments=_('#comments_holder>ul>li');}
return this.root_comments;},showCommentForm:function(link){var commentBlock=getParentByClassName(link,'comment_block');if(matchClass(commentBlock,'is_replied')){commentForm.cancelComment(link);return false;}
commentForm.clearEditingComments();commentForm.clearEditingForm();var formPlace=$('comment_form_place');var form=$('comment_form');addClass(formPlace,'form_is_hidden');removeClass(formPlace,'show_editor');removeClass(form,'show_editor');form.is_used=true;var hiddenField=form['fk_comment'];var label=form.getElementsByTagName('label')[0];var textarea=form.getElementsByTagName('textarea')[0];var commentHolder=getParentByClassName(commentBlock,'comment_holder');var commentAuthor=getElementsByClassName(commentBlock,'*','comment_author')[0].innerHTML;var commentId=commentBlock.id;label.innerHTML='Ваш ответ сообщнику '+commentAuthor;hiddenField.value=toInteger(commentId);if(commentBlock.nextSibling){commentHolder.insertBefore(form,commentBlock.nextSibling);}else{commentHolder.appendChild(form);}
addClass(commentBlock,'is_replied');commentForm.showChildren(link);textarea.focus();return false;},editComment:function(link){commentForm.clearEditingComments();commentForm.clearEditingForm();var formPlace=$('comment_form_place');var form=$('comment_form');addClass(formPlace,'form_is_hidden');removeClass(formPlace,'show_editor');removeClass(form,'show_editor');form.is_used=true;var hiddenField=form['fk_comment'];var hiddenFieldEdit=form['pk_comment'];var label=form.getElementsByTagName('label')[0];var textarea=form.getElementsByTagName('textarea')[0];var commentBlock=getParentByClassName(link,'comment_block');var commentHolder=getParentByClassName(commentBlock,'comment_holder');var commentBody=getElementsByClassName(commentBlock,'*','comment_body')[0];var commentId=commentBlock.id;label.innerHTML='Редактирование комментария';hiddenField.value='0';hiddenFieldEdit.value=toInteger(commentId);textarea.value=commentBody.innerHTML.replace(/(^\s+)|(\s+$)/g,"").replace(/<[bB][rR]\s?\/?>/g,'\n');addClass(commentBlock,'editing_comment')
addClass(form,'editing_comment_form');if(commentBlock.nextSibling){commentHolder.insertBefore(form,commentBlock.nextSibling);}else{commentHolder.appendChild(form);}
commentForm.showChildren(link);textarea.focus();return false;},cancelComment:function(link){commentForm.showCommentFormInplace();return false;},clearMenuTools:function(){var menuTools=$('menu_tools');removeClass(menuTools,'show_all');removeClass(menuTools,'show_new_only');removeClass(menuTools,'collapse_all');removeClass(menuTools,'show_popular_only');},showCommentFormInplace:function(shownByUser,notMakeScroll){var form=$('comment_form');if(!form)return false;commentForm.clearEditingComments();commentForm.clearEditingForm();var label=form.getElementsByTagName('label')[0];label.innerHTML='Ваш комментарий';var formPlace=$('comment_form_place');if(formPlace){formPlace.appendChild(form);}else{alert('Ошибка в выводе HTML');}
removeClass(formPlace,'show_editor');removeClass(form,'show_editor');if(shownByUser){removeClass(formPlace,'form_is_hidden');if(!notMakeScroll){var textarea=form.getElementsByTagName('textarea')[0];textarea.focus();scrollToElement(formPlace);}
}else{addClass(formPlace,'form_is_hidden');}
return false;},expandAll:function(){this.clearCollapse();this.clearShowNewOnly();return false;},collapseAll:function(){var parents=this.getRootComments();for(var i=0;i<parents.length;i++){addRemoveClass(parents[i],['hide_children'],['show_newonly','show_popular_only']);}
commentForm.clearMenuTools();addClass($('menu_tools'),'collapse_all');this.showUserComments(this.currentUserClassName,false);this.showCommentFormInplace();return false;},clearCollapse:function(){var globalParent=$('comments_holder');var parents=getElementsByClassName(globalParent,'li','hide_children');for(var i=0;i<parents.length;i++){removeClass(parents[i],'hide_children');}
removeClass($('menu_tools'),'collapse_all');},showChildren:function(link){var parent=getParentByClassName(link,'comment_holder');removeClass(parent,'hide_children');removeClass(parent,'show_newonly');removeClass(parent,'show_popular_only');removeClass(parent,'show_'+this.currentUserClassName);return false;},hideChildren:function(link){var parent=getParentByClassName(link,'comment_holder');addClass(parent,'hide_children');removeClass(parent,'show_newonly');removeClass(parent,'show_popular_only');this.showCommentFormInplace();return false;},showNewOnly:function(flag){if(flag){ 
commentForm.clearMenuTools();addClass($('menu_tools'),'show_new_only');}else{ 
commentForm.clearMenuTools();addClass($('menu_tools'),'show_all');}
var parents=this.getRootComments();for(var i=0;i<parents.length;i++){if(flag){addRemoveClass(parents[i],['show_newonly'],['hide_children','show_popular_only']);}else{addRemoveClass(parents[i],[],['hide_children','show_popular_only','show_newonly']);}
}
this.showUserComments(this.currentUserClassName,false);this.clearShowAnyCase();this.showCommentFormInplace();return false;},showPopular:function(){var parents=this.getRootComments();for(var i=0;i<parents.length;i++){addRemoveClass(parents[i],['show_popular_only'],['show_newonly','hide_children']);}
commentForm.clearMenuTools();addClass($('menu_tools'),'show_popular_only');this.showUserComments(this.currentUserClassName,false);this.clearShowAnyCase();this.showCommentFormInplace();return false;},showUserComments:function(uid,flag){var commentatorsBlock=$('commentators');if(commentatorsBlock){removeClass(commentatorsBlock,'current_'+this.currentUserClassName);}
var parents=this.getRootComments();if(!flag){for(var i=0;i<parents.length;i++){removeClass(parents[i],'show_'+uid);}
return false;}
for(var i=0;i<parents.length;i++){addRemoveClass(parents[i],['show_'+uid],['show_'+this.currentUserClassName]);}
var css='';css+='.show_'+uid+' .comment_block{display:none;}';css+='.show_'+uid+' .'+uid+'{display:block;}';css+='.show_'+uid+' .show_anycase{display:block;}';css+='#commentators.current_'+uid+' .'+uid+'{font-weight:bold;}';addStyleProperties(css);addClass(commentatorsBlock,'current_'+uid);this.currentUserClassName=uid;this.clearShowAnyCase();this.clearMenuTools();this.clearCollapse();this.clearPopular();this.showCommentFormInplace();return false;},clearShowNewOnly:function(){var globalParent=$('comments_holder');var parents=getElementsByClassName(globalParent,'*','show_newonly');for(var i=0;i<parents.length;i++){removeClass(parents[i],'show_newonly');}
},clearShowAnyCase:function(){var globalParent=$('comments_holder');var showAnycaseBlocks=getElementsByClassName(globalParent,'*','show_anycase');for(var i=0;i<showAnycaseBlocks.length;i++){removeClass(showAnycaseBlocks[i],'show_anycase');}
},clearPopular:function(){var globalParent=$('comments_holder');var parents=getElementsByClassName(globalParent,'*','show_popular_only');for(var i=0;i<parents.length;i++){removeClass(parents[i],'show_popular_only');}
},clearEditingComments:function(){var globalParent=$('comments_holder');var editingComments=getElementsByClassName(globalParent,'*','editing_comment');for(var i=0;i<editingComments.length;i++){removeClass(editingComments[i],'editing_comment');}
},clearEditingForm:function(){var form=$('comment_form');var hiddenField=form['fk_comment'];var hiddenFieldEdit=form['pk_comment'];var commentBlockId='comment_'+form['fk_comment'].value;var commentBlock=$(commentBlockId);if(commentBlock){removeClass(commentBlock,'is_replied');}
hiddenField.value='0';hiddenFieldEdit.value='0';removeClass(form,'editing_comment_form');},showParent:function(link){var commentsParent=getParentByClassName(link,'comments_parent');var commentHolder=getParentByClassName(commentsParent,'comment_holder');var parent=getElementsByClassName(commentHolder,'*','comment_block')[0];var parentHead=getElementsByClassName(parent,'*','comment_head')[0];var child=getParentByClassName(link,'comment_block');addClass(parent,'show_anycase');scrollToElement(parent);var showChilds=getElementsByClassName(parentHead,'*','link_to_child');var showChild;if(showChilds&&showChilds.length){showChild=showChilds[0];showChild.href='#'+child.id;showChild.onclick=function(){return commentForm.showChild(this,child);}
}else{showChild=document.createElement('a');showChild.className='system link_to_child';showChild.title='Вернуться к комментарию,откуда пришли';showChild.href='#'+child.id;showChild.innerHTML='&darr;';showChild.onclick=function(){return commentForm.showChild(this,child);}
parentHead.appendChild(showChild);}
return false;},showChild:function(link,child){link.parentNode.removeChild(link);scrollToElement(child);return false;},checkShowComments:function(){var hashNew=window.location.href.match('new_comment');var newComments=getElementsByClassName($('comments_holder'),'*','comment_new');if(hashNew){if(newComments.length > 0){this.showNewOnly(true);}else{var whereToScroll;if($('menu_tab')){whereToScroll=$('menu_tab');}else{whereToScroll=$('comments');}
setTimeout(function(){scrollToElement(whereToScroll)},500);}
}
},initCommentForm:function(){var form=$('comment_form');var comments=$('comments');var commentBlocks=null;if(!form.is_used){if(comments){ 
commentsBlock=getElementsByClassName(comments,'*','comment_block');}
if(commentsBlock.length){this.showCommentFormInplace();}else{this.showCommentFormInplace(true,true);}
}
},jsonResponseHandler_comments:function(json,params){window.DTIME=json.comments.dtime;for(var i=0;i<json.comments.comments.length;i++){var comment=json.comments.comments[i];var parentId=comment[0];var commentHtml=comment[1];var ulCurrent;var li=document.createElement('li');li.className='comment_holder';li.innerHTML=commentHtml;if(parentId!=0){var parent=getParentByClassName($('comment_'+parentId),'comment_holder');var uls=getElementsByClassName(parent,'*','comments_parent');if(uls&&uls.length){uls[0].appendChild(li);ulCurrent=uls[0];}else{var ul=document.createElement('ul');ul.className='comments_parent';ul.appendChild(li);parent.appendChild(ul);ulCurrent=ul;}
}else{addClass(li,'no_children');var uls=getElementsByClassName($('comments_holder'),'*','comments_parent');if(uls&&uls.length){uls[0].appendChild(li);ulCurrent=uls[0];}else{var ul=document.createElement('ul');ul.className='comments_parent';ul.appendChild(li);$('comments_holder').appendChild(ul);ulCurrent=ul;}
}
var ulCurrentParentNode=ulCurrent.parentNode;if(ulCurrentParentNode&&matchClass(ulCurrentParentNode,'no_children')){var parentComment=$('comment_'+parentId);var parentCommentArrowHolders=getElementsByClassName(parentComment,'*','comment_tools');var parentCommentArrowHolder=null;var rootCommentArrows=null;if(parentCommentArrowHolders.length){parentCommentArrowHolder=parentCommentArrowHolders[0];rootCommentArrows=$('root_comment_arrows').cloneNode(true);rootCommentArrows.removeAttribute('id');parentCommentArrowHolder.appendChild(rootCommentArrows);}
removeClass(ulCurrentParentNode,'no_children');}
if(imageResizer&&imageResizer.resizeImages){imageResizer.resizeAllImages(li);}
var commentBlock=getElementsByClassName(li,'*','comment_block')[0];addClass(commentBlock,'show_anycase');}
if(json.comments.commentModified){var comment=json.comments.commentModified;var commentId=comment[0];var commentHtml=comment[1];var div=document.createElement('div');div.innerHTML=commentHtml;var commentNew=getElementsByClassName(div,'*','comment_block')[0];var commentReplaced=$('comment_'+commentId);commentReplaced.parentNode.insertBefore(commentNew,commentReplaced);addClass(commentNew,'show_anycase');commentReplaced.parentNode.removeChild(commentReplaced);}else{if($('comments_counter')){$('comments_counter').innerHTML=parseInt($('comments_counter').innerHTML)+1;}
if($('comments_counter_tab')){$('comments_counter_tab').innerHTML=parseInt($('comments_counter_tab').innerHTML)+1;}
}
this.showCommentFormInplace();var textarea=$('comment_form')['comment'];textarea.value='';var commentId=json.comments.pk_comment;scrollToElement($('comment_'+commentId));},sendDataOnload:function(ajaxObj,params){this.clearLoading(params);if(ajaxObj&&ajaxObj.responseText){var json=null;var errorServer=null;try{eval('json='+ajaxObj.responseText);}catch(e){var form=$('comment_form');var textarea=form['comment'];this.markField_error(textarea,'Ошибка на сервере,'+' попробуйте перезагрузить страницу '+'(CTRL+F5)');textarea.onfocus=null;errorServer=true;}
if(!errorServer){for(var prop in json){if(this.jsonResponse[prop].handler){this[this.jsonResponse[prop].handler](json,params);}
}
}
}
},showEditor:function(link){var parent=getParentByClassName(link,'comment_form');var formPlace=$('comment_form_place');if(matchClass(parent,'show_editor')){removeClass(parent,'show_editor');removeClass(formPlace,'show_editor');}else{addClass(parent,'show_editor');addClass(formPlace,'show_editor');}
return false;}
});var commentForm=new commentFormClass();var postFormClass=function(){postFormClass.superClass.apply(this,arguments);Object.extendObject(this.jsonResponse,{checked:{handler:'jsonResponseHandler_checked'
}
});}
postFormClass.inheritsFrom(ajaxFormClass);Object.extendObject(postFormClass.prototype,{getAjaxUrl:function(field){var so=field.form.action.match(/.+?\?_so=([\w.-]+)/)[1];var name=field.name.split('[')[0];var url=window.SITE_URL+'ajax/form_check/?'+
'_so='+so+'&'+
'field='+name;return url;},checkField_name:function(e,field){if(!e)e=window.event;switch(e.type){case 'keydown':
this.markField_clear(field);break;case 'blur':
if(field.value.length==''){ 
this.markField_error(field,this.errorMessages.fieldIsEmpty);}
break;}
},checkField_video:function(e,field){if(!e)e=window.event;switch(e.type){case 'keydown':
this.markField_clear(field);break;case 'blur':
if(field.value.length==''){ 
this.markField_clear(field);return;}else{this.checkData(field);}
break;case 'change':
break;}
},checkField_imageLink:function(e,field){if(!e)e=window.event;switch(e.type){case 'keydown':
this.markField_clear(field);break;case 'blur':
if(field.value.length==''){ 
this.markField_clear(field);return;}else{this.checkData(field);}
break;case 'change':
break;}
},insertPreviewImage:function(field,previewUrl){var blockHolder=getParentByClassName(field,'field_holder');var previewHolders=getElementsByClassName(blockHolder,'*','preview_holder');if(previewHolders&&previewHolders.length){ 
previewHolders[0].innerHTML='';var img=document.createElement('img');img.src=previewUrl;img.removeAttribute('width');
previewHolders[0].appendChild(img);}
},removePreviewImage:function(field){var blockHolder=getParentByClassName(field,'field_holder');var previewHolders=getElementsByClassName(blockHolder,'*','preview_holder');if(previewHolders&&previewHolders.length){ 
previewHolders[0].innerHTML='';}
},jsonResponseHandler_error:function(json,params){postFormClass.superClass.prototype.jsonResponseHandler_error.apply(this,arguments);if(params.field){this.removePreviewImage(params.field);}
},jsonResponseHandler_checked:function(json,params){if(params.field){var fieldParent=getParentByClassName(params.field,this.classNames.fieldHolder);if(fieldParent)removeClass(fieldParent, this.classNames.isLoading);}else if(params.loadingClassName){removeClass(params.form,params.loadingClassName);}
for(prop in json.checked){if(typeof json.checked[prop]!='string'){for(p in json.checked[prop]){var fieldMarkedChecked=params.form[prop+'['+p+']'];if(fieldMarkedChecked){this.markField_checked(fieldMarkedChecked);if(json.checked[prop][p].preview){ 
this.insertPreviewImage(fieldMarkedChecked,json.checked[prop][p].preview)
}
}
}
}
}
}
});var postForm=new postFormClass();uploadForm={prepareForm:function(form){var formButtons=getElementsByClassName(form,'*',postForm.classNames.fieldButton);for(var i=0;i<formButtons.length;i++){if(formButtons[i].name){formButtons[i].onclick=function(){uploadForm.createHiddenField(this);}
}
}
addEvent(form,'submit',function(){uploadForm.setLoading(form)}
);if(formButtons.length){addEvent(window,'unload',function(){uploadForm.clearLoading(form)}
);}
},setLoading:function(form){postForm.setLoading({form:form,loadingClassName:'loading'
});},clearLoading:function(form){postForm.clearLoading({form:form,loadingClassName:'loading'
});},createHiddenField:function(button){var input=document.createElement('input');input.type='hidden';input.name=button.name;input.value=button.value;button.parentNode.insertBefore(input,button);}
}
suggestTagsClass=function(){suggestTagsClass.superClass.apply(this,arguments);Object.extendObject(this.jsonResponse,{result:{handler:'jsonResponseHandler_tags'
}
});Object.extendObject(this.classNames,{tagsHolder:'tags_holder' 
});}
suggestTagsClass.inheritsFrom(ajaxFormClass);Object.extendObject(suggestTagsClass.prototype,{getAjaxUrl:function(field){var url=window.SITE_URL+'ajax/gift_tags_by_title/'+'?'+'title='+encodeURIComponent(field.value);return url;},getTags:function(field){if(field.value=='')return false;this.checkData(field);},jsonResponseHandler_tags:function(json,params){var tagsHolder=$('suggest_tags_holder');if(tagsHolder&&json.result){if(json.result!=''){tagsHolder.innerHTML=json.result;}else{tagsHolder.innerHTML='не обнаружено';}
}
}
});var suggestTags=new suggestTagsClass();var selectListHandler={getAjaxUrl:function(){return window.SITE_URL+'ajax/';},loadingListType:{country:{parentClassName:'place_meeting_country'
},region:{parentType:'country',parentClassName:'place_meeting_region',dataString:'regions_get',onloadHandler:function(json,params){selectListHandler.onloadHandler(json,params);var selectListCityParent=getElementsByClassName(params.commonParent,'*',selectListHandler.loadingListType['city'].parentClassName)[0];var selectListCity=selectListCityParent.getElementsByTagName('select')[0];if(!params.selectValue){selectListHandler.resetSelectList(selectListCity);}
}
},city:{parentType:'region',parentClassName:'place_meeting_city',dataString:'cities_get',onloadHandler:function(json,params){selectListHandler.onloadHandler(json,params);}
}
},load:function(link,type,linkValue,selectValue){var commonParent=getParentByClassName(link,'place_meeting_common_parent');var loadingListParent=getElementsByClassName(commonParent,'*',selectListHandler.loadingListType[type].parentClassName)[0];var loadingList=loadingListParent.getElementsByTagName('select')[0];var data=''+selectListHandler.getAjaxUrl()+selectListHandler.loadingListType[type].dataString+'/?'+'id='+(linkValue ?linkValue:link.value);var params={commonParent:commonParent,loadingListType:type,loadingListParent:loadingListParent,loadingListName:loadingList.name,selectValue:selectValue ?selectValue:null
};selectListHandler.disableSelectLists(params);ajaxGet(data,selectListHandler.onload,params);},onload:function(ajaxObj,params){eval('var json='+ajaxObj.responseText);selectListHandler.loadingListType[params.loadingListType].onloadHandler(json,params);selectListHandler.enableSelectLists(params);},onloadHandler:function(json,params){var commonParent=params.commonParent;var loadingListParent=params.loadingListParent;var loadingListName=params.loadingListName;var list=json.result;loadingListParent.innerHTML=list;var select=loadingListParent.getElementsByTagName('select')[0];select.name=loadingListName;select.value=params.selectValue;},resetSelectList:function(selectList){var optionNodes=selectList.getElementsByTagName('option');for(var i=optionNodes.length-1;i>-1;i--){if(optionNodes[i].value!=0){selectList.removeChild(optionNodes[i]);}
}
},disableSelectLists:function(params){var commonParent=params.commonParent;var blockHolder=getParentByClassName(commonParent,'block_holder');addClass(blockHolder,'loading');var lists=commonParent.getElementsByTagName('select');for(var i=0;i<lists.length;i++){lists[i].disabled=true;}
},enableSelectLists:function(params){var commonParent=params.commonParent;var blockHolder=getParentByClassName(commonParent,'block_holder');removeClass(blockHolder,'loading');var lists=commonParent.getElementsByTagName('select');for(var i=0;i<lists.length;i++){lists[i].disabled=false;}
},restoreFocus:function(params){var commonParent=params.commonParent;var type=selectListHandler.loadingListType[params.loadingListType].parentType;var selectListParent=getElementsByClassName(commonParent,'*',selectListHandler.loadingListType[type].parentClassName)[0];var selectList=selectListParent.getElementsByTagName('select')[0];selectList.focus();},getLocalIndex:function(commonParent){var selectListCountry=getElementsByClassName(commonParent,'*','place_meeting_country')[0].getElementsByTagName('select')[0];var localIndex=selectListCountry.name.match(/place_meeting\[(\d+)\]\[pk_country\]/)[1];return localIndex;},autoLoad:function(countryId,regionId,cityId,link){var parent=getParentByClassName(link,'block_holder');var selectParentCountry=getElementsByClassName(parent,'*',selectListHandler.loadingListType['country'].parentClassName)[0];var selectCountry=selectParentCountry.getElementsByTagName('select')[0];selectCountry.value=countryId;selectListHandler.load(selectCountry,'region',countryId,regionId);var selectParentRegion=getElementsByClassName(parent,'*',selectListHandler.loadingListType['region'].parentClassName)[0];var selectRegion=selectParentRegion.getElementsByTagName('select')[0];selectListHandler.load(selectRegion,'city',regionId,cityId);var selectParentCity=getElementsByClassName(parent,'*',selectListHandler.loadingListType['city'].parentClassName)[0];var selectCity=selectParentCity.getElementsByTagName('select')[0];return false;},clearSelect:function(link){var parent=getParentByClassName(link,'block_holder');var selectParentCountry=getElementsByClassName(parent,'*',selectListHandler.loadingListType['country'].parentClassName)[0];var selectCountry=selectParentCountry.getElementsByTagName('select')[0];selectCountry.value=0;selectListHandler.load(selectCountry,'region');return false;},changeIncludeCityCheckbox:function(select){var commonParent=$('geo_anywhere_holder');if(commonParent&&select){if(select.value&&select.value!=0){removeClass(commonParent,'show_geo_onlynogeo');addClass(commonParent,'show_geo_anywhere');}else{removeClass(commonParent,'show_geo_anywhere');addClass(commonParent,'show_geo_onlynogeo');$('geo_anywhere').checked=false;$('geo_mail').checked=false;}
}
}
}
var blockClonerClass=function(){this.classNames={addButton:'one_more',
delButton:'delete_block',
blockClone:'block_holder',
blockCloneProto:'block_clone_proto',
blockCloneParent:'block_clone_parent',
blockPreview:'block_preview',
blockAdd:'block_additional',
isFull:'is_full',
isOverFull:'is_over_full',
isShrinked:'is_shrinked',
clonedBlock:'cloned',
dataField:'data',
flagToDelete:'flag_to_delete' 
},this.inheritedClassNames=[
'error','checked','loading','is_full'
],this.regExps={currentIndex:/\[(\d*)\]/,replacedIndex:/([a-z]+\[)\d*(\])/,maxNumberOfBlocks:/maxch_(\d+)/
}
}
Object.extendObject(blockClonerClass.prototype,{addBlock:function(link,doCopyOfValue){var blockCloneParent=getParentByClassName(link,this.classNames.blockCloneParent);var blockToInsertBefore=getParentByClassName(link,this.classNames.addButton);var blockCloneProto=getElementsByClassName(blockCloneParent,'*',this.classNames.blockCloneProto)[0];var clone=blockCloneProto.cloneNode(true);this.setFieldsIndexes(clone,blockCloneParent);if(doCopyOfValue){ 
this.copyBlockFields(clone,blockCloneProto);}else{ 
this.clearBlockFields(clone);}
this.clearBlockElements(clone);this.clearBlockStyles(clone);this.removePreviewImage(clone);addClass(clone,this.classNames.clonedBlock);blockCloneParent.insertBefore(clone,blockToInsertBefore);this.setRestrictionToClone(blockCloneParent);return false;},deleteBlock:function(link){var blockToDelete=getParentByClassName(link,this.classNames.blockClone);var blockCloneParent=getParentByClassName(link,this.classNames.blockCloneParent);var numberOfBlocks=this.checkNumberOfBlocks(blockCloneParent);if(numberOfBlocks==1){ 
this.clearBlockFields(blockToDelete);this.clearBlockElements(blockToDelete);this.clearBlockStyles(blockToDelete);addClass(blockToDelete,this.classNames.blockCloneProto);this.removePreviewImage(blockToDelete);this.shrinkBlock(blockCloneParent);this.markBlockToDelete(blockCloneParent);}else if(matchClass(blockToDelete,this.classNames.blockCloneProto)){ 
if(this.checkNumbersOfRealBlocks(blockCloneParent)> 1){blockCloneParent.removeChild(blockToDelete);this.setNewBlockProto(blockCloneParent);this.setRestrictionToClone(blockCloneParent);}else{ 
this.clearBlockFields(blockToDelete);this.removePreviewImage(blockToDelete);for(var i=0;i<this.inheritedClassNames.length;i++){removeClass(blockToDelete,this.inheritedClassNames[i]);}
}
}else{ 
blockCloneParent.removeChild(blockToDelete);this.setRestrictionToClone(blockCloneParent);}
return false;},removePreviewImage:function(clone){var previewHolders=getElementsByClassName(clone,'*','preview_holder');if(previewHolders&&previewHolders.length){var imgs=previewHolders[0].getElementsByTagName('img');if(imgs&&imgs.length){previewHolders[0].removeChild(imgs[0]);}
}
},setFieldsIndexes:function(clone,blockCloneParent){var currentIndex=this.getCurrentIndex(blockCloneParent);if(currentIndex!=''){currentIndex=currentIndex-0+1;}
var datas=getElementsByClassName(clone,'*',this.classNames.dataField);for(var i=0;i<datas.length;i++){var oldName=datas[i].name;var newName=datas[i].name.replace(this.regExps.replacedIndex,'$1'+currentIndex+'$2');datas[i].name=newName;}
var parents=getElementsByClassName(clone,'*',this.classNames.blockCloneParent);for(var i=0;i<parents.length;i++){var oldId=parents[i].id;var newId=parents[i].id.replace(this.regExps.replacedIndex,'$1'+currentIndex+'$2');parents[i].id=newId;}
},getCurrentIndex:function(blockCloneParent){var blockHolders=getElementsByClassName(blockCloneParent,'*',this.classNames.blockClone);var lastBlockHolder=blockHolders[blockHolders.length -1];var inputs=getElementsByClassName(lastBlockHolder,'*',this.classNames.dataField);currentIndex=inputs[0].name.match(this.regExps.currentIndex)[1];return currentIndex;},clearBlockElements:function(clone){var clonedBlocks=getElementsByClassName(clone,'*',this.classNames.clonedBlock);for(var i=0;i<clonedBlocks.length;i++){if(clonedBlocks[i]){ 
var parent=clonedBlocks[i].parentNode;parent.removeChild(clonedBlocks[i]);}
}
},clearBlockFields:function(block){var datas=getElementsByClassName(block,'*',this.classNames.dataField);for(var i=0;i<datas.length;i++){if(datas[i].tagName.toLowerCase()=='input'){if(datas[i].type=='checkbox'){datas[i].checked=false;}else if(datas[i].type=='radio'){if(datas[i].value==0){datas[i].checked=true;}
}else{datas[i].value='';}
}else if(datas[i].tagName.toLowerCase()=='select'){datas[i].value=0;if(datas[i].name.match(/pk_country/)&& window.selectListHandler){selectListHandler.load(datas[i],'region');}
}else if(datas[i].tagName.toLowerCase()=='textarea'){datas[i].value='';}
}
},copyBlockFields:function(clone,blockCloneProto){var datas=getElementsByClassName(clone,'*',this.classNames.dataField);var datasProto=getElementsByClassName(blockCloneProto,'*',this.classNames.dataField);for(var i=0;i<datas.length;i++){datas[i].value=datasProto[i].value;}
},clearBlockStyles:function(clone){for(var i=0;i<this.inheritedClassNames.length;i++){removeClass(clone,this.inheritedClassNames[i]);var elements=getElementsByClassName(clone,'*',this.inheritedClassNames[i]);for(var j=0;j<elements.length;j++){removeClass(elements[j],this.inheritedClassNames[i]);}
}
removeClass(clone,this.classNames.blockCloneProto);},checkNumberOfBlocks:function(blockCloneParent){var blocks=getElementsByClassName(blockCloneParent,'*',this.classNames.blockClone);return blocks.length;},checkNumbersOfRealBlocks:function(blockCloneParent){var blocks=getElementsByClassName(blockCloneParent,'*',this.classNames.blockClone);var blocksPreview=getElementsByClassName(blockCloneParent,'*',this.classNames.blockPreview);return(blocks.length-blocksPreview.length);},setRestrictionToClone:function(blockCloneParent){haveClassName=blockCloneParent.className.match(this.regExps.maxNumberOfBlocks);if(haveClassName){var maxNumberOfBlocks=haveClassName[1];var numberOfBlocks=this.checkNumberOfBlocks(blockCloneParent);if(numberOfBlocks > maxNumberOfBlocks){ 
addClass(blockCloneParent,this.classNames.isOverFull);addClass(blockCloneParent,this.classNames.isFull);return true;}else if(numberOfBlocks==maxNumberOfBlocks){removeClass(blockCloneParent,this.classNames.isOverFull);
addClass(blockCloneParent,this.classNames.isFull);return true;}else{ 
removeClass(blockCloneParent,this.classNames.isFull);return false;}
}
},shrinkBlock:function(blockCloneParent){addClass(blockCloneParent,this.classNames.isShrinked);},unshrinkBlock:function(link,blockCloneParent){if(!blockCloneParent){var blockCloneParent=getParentByClassName(link,this.classNames.blockCloneParent);}
removeClass(blockCloneParent,this.classNames.isShrinked);this.unMarkBlockToDelete(blockCloneParent);return false;},setNewBlockProto:function(blockCloneParent){var blocks=getElementsByClassName(blockCloneParent,'*',this.classNames.blockClone);for(var i=0;i<blocks.length;i++){if(!matchClass(blocks[i],this.classNames.blockPreview)){addClass(blocks[i],this.classNames.blockCloneProto);removeClass(blocks[i],this.classNames.clonedBlock);break;}
}
},setBlockShrinking:function(blockCloneParent){if(this.checkEmptyBlock(blockCloneParent)){this.shrinkBlock(blockCloneParent);}
},checkEmptyBlock:function(blockCloneParent){var emptyBlock=true;var datas=getElementsByClassName(blockCloneParent,'*',this.classNames.dataField);for(var i=0;i<datas.length;i++){if(!matchClass(datas[i],this.classNames.flagToDelete)&&
datas[i].type!='radio' &&
datas[i].value!='' &&
datas[i].value!=0){emptyBlock=false;break;}else if(datas[i].type=='radio' &&
datas[i].checked &&
datas[i].value!=0){emptyBlock=false;break;}
}
return emptyBlock;},markBlockToDelete:function(blockCloneParent){var flagsToDelete=getElementsByClassName(blockCloneParent,'input',this.classNames.flagToDelete);for(var i=0;i<flagsToDelete.length;i++){flagsToDelete[i].value=1;
}
},unMarkBlockToDelete:function(blockCloneParent){var flagsToDelete=getElementsByClassName(blockCloneParent,'input',this.classNames.flagToDelete);for(var i=0;i<flagsToDelete.length;i++){flagsToDelete[i].value='';
}
}
});var blockCloner=new blockClonerClass();var blockClonerFilterClass=function(){blockClonerFilterClass.superClass.apply(this,arguments);Object.extendObject(this.classNames,{addButton:'one_more_filter',
blockClone:'block_holder_filter',
isFull:'is_full_filter',
isShrinked:'is_shrinked_filter'
});};blockClonerFilterClass.inheritsFrom(blockClonerClass);var blockClonerFilter=new blockClonerFilterClass();var blockClonerFilterElementClass=function(){blockClonerFilterElementClass.superClass.apply(this,arguments);Object.extendObject(this.regExps,{currentIndex:/[a-z]+\[\d*\]\[[a-z]+\]\[(\d*)\]/,replacedIndex:/([a-z]+\[\d*\]\[[a-z]+\]\[)\d*(\])/
});};blockClonerFilterElementClass.inheritsFrom(blockClonerClass);var blockClonerFilterElement=new blockClonerFilterElementClass();var blockShrinker={shrink:function(block,link){var block;if(block){block=block;}else{block=getParentByClassName(link,'shrinking_parent');}
if(matchClass(block,'shrinked')){removeClass(block,'shrinked');}else{addClass(block,'shrinked');}
imageResizer.resizeAllImages(block);return false;},addSwitcher:function(block){var shrinkingSwitcher=getElementsByClassName(block,'*','shrinking_switcher')[0];shrinkingSwitcher.onclick=function(){blockShrinker.shrink(block,shrinkingSwitcher);};}
}
var showEvents={thisEvent:function(link){var parent=getParentByClassName(link,'event_action_block');if(parent){if(matchClass(parent,'show_old')){removeClass(parent,'show_old');}else{addClass(parent,'show_old');}
}
return false;},allEvents:function(link){var body=document.getElementsByTagName('body')[0];var eventBlocks=getElementsByClassName(body,'*','event_action_block');var parent=getParentByClassName(link,'event_action_block');if(parent){if(matchClass(parent,'show_old')){for(var i=0;i<eventBlocks.length;i++){removeClass(eventBlocks[i],'show_old');}
}else{for(var i=0;i<eventBlocks.length;i++){addClass(eventBlocks[i],'show_old');}
}
}
return false;}
}
var showResponse={showResponseInfo:function(id){var responseReturnBlock=$('response_return_'+id);var responseInfoBlock=$('response_info_'+id);if(responseReturnBlock)addClass(responseReturnBlock,'shrinked');if(responseInfoBlock)blockShrinker.shrink(responseInfoBlock);return false;},showResponseReturn:function(id){var responseReturnBlock=$('response_return_'+id);var responseInfoBlock=$('response_info_'+id);if(responseInfoBlock)addClass(responseInfoBlock,'shrinked');if(responseReturnBlock){blockShrinker.shrink(responseReturnBlock);}
return false;}
}
var showGroupTools={shrinkFilter:function(){var block=$('group_gifts_search');if(block)addClass(block,'shrinked');blockShrinker.shrink($('group_filter_settings'));return false;},shrinkSearch:function(){var block=$('group_filter_settings');if(block)addClass(block,'shrinked');blockShrinker.shrink($('group_gifts_search'));return false;}
}
var shrinkFooter=function(){var body=document.getElementsByTagName('body')[0];if(matchClass(body,'footer_shrinked')){removeClass(body,'footer_shrinked');}else{addClass(body,'footer_shrinked');}
return false;}
var changeDarStatusHandler={getAjaxUrl:function(){return window.SITE_URL+'ajax_request/';},currentStatus:null,init:function(formId){var form=$(formId);var radios=getElementsByClassName(form,'input','radio_field');for(var i=0;i<radios.length;i++){if(radios[i].checked){changeDarStatusHandler.currentStatus=radios[i].value;break;}
}
},send:function(link){var data=''+changeDarStatusHandler.getAjaxUrl()+'?'+'interface=Gift'+'&'+'action=setStatus'+'&'+
'pk_gift='+link.form['pk_gift'].value+'&'+'status='+link.value;var params={link:link,statusOld:0
}
changeDarStatusHandler.disableRadioButtons(params);ajaxGet(data,changeDarStatusHandler.onload,params);},onload:function(ajaxObj,params){var ok=parseInt(ajaxObj.responseText);if(ok){ 
changeDarStatusHandler.currentStatus=params.link.value;}else{ 
alert('Ошибка,невозможно сменить статус');var radios=getElementsByClassName(params.link.form,'input','radio_field');for(var i=0;i<radios.length;i++){radios[i].checked=false;if(radios[i].value==changeDarStatusHandler.currentStatus){radios[i].checked=true;}
}
}
changeDarStatusHandler.enableRadioButtons(params);},disableRadioButtons:function(params){var commonParent=params.link.form;var radios=getElementsByClassName(commonParent,'input','radio_field');for(var i=0;i<radios.length;i++){radios[i].disabled=true;}
},enableRadioButtons:function(params){var commonParent=params.link.form;var radios=getElementsByClassName(commonParent,'input','radio_field');for(var i=0;i<radios.length;i++){radios[i].disabled=false;}
}
}
wishersViewer={showAll:function(){wishersViewer.clearView();addClass($('menu_tools'),'show_all');return false;},showNewOnly:function(){wishersViewer.clearView();addClass($('gift_wishers'),'show_new_only');addClass($('menu_tools'),'show_new_only');return false;},showPromisedOnly:function(){wishersViewer.clearView();addClass($('gift_wishers'),'show_promised_only');addClass($('menu_tools'),'show_promised_only');return false;},showRefusedOnly:function(){wishersViewer.clearView();addClass($('gift_wishers'),'show_refused_only');addClass($('menu_tools'),'show_refused_only');return false;},clearView:function(){wishersViewer.clearMenuTools();var wishersHolder=$('gift_wishers');removeClass(wishersHolder,'show_new_only');removeClass(wishersHolder,'show_promised_only');removeClass(wishersHolder,'show_refused_only');},clearMenuTools:function(){var menuTools=$('menu_tools');removeClass(menuTools,'show_all');removeClass(menuTools,'show_new_only');removeClass(menuTools,'show_promised_only');removeClass(menuTools,'show_refused_only');},checkShowWishers:function(){var hashNew=window.location.href.match('new_wishers');if(hashNew){wishersViewer.showNewOnly();}
},checkShowPromised:function(){var hashPromised=window.location.href.match('promised_wishers');if(hashPromised){wishersViewer.showPromisedOnly();scrollToElement($('menu_tab'));}
}
}
responsesViewer={showAll:function(){responsesViewer.clearView();var menuTools=$('menu_tools');if(menuTools){addClass($('menu_tools'),'show_all');}
return false;},showPositiveOnly:function(){responsesViewer.clearView();addClass($('user_responses_list'),'show_positive_only');addClass($('menu_tools'),'show_positive_only');return false;},showNegativeOnly:function(){responsesViewer.clearView();addClass($('user_responses_list'),'show_negative_only');addClass($('menu_tools'),'show_negative_only');return false;},clearView:function(){responsesViewer.clearMenuTools();var responsesHolder=$('user_responses_list');removeClass(responsesHolder,'show_positive_only');removeClass(responsesHolder,'show_negative_only');var userNote=$('user_note_nav');var userNoteForm=$('user_note_form');if(userNote&&userNoteForm){addClass(userNoteForm,'shrinked');removeClass(userNote,'shrinked');}
},clearMenuTools:function(){var menuTools=$('menu_tools');if(menuTools){removeClass(menuTools,'show_all');removeClass(menuTools,'show_positive_only');removeClass(menuTools,'show_negative_only');}
},showForm:function(){responsesViewer.showAll();var userNote=$('user_note_nav');var userNoteForm=$('user_note_form');if(userNote&&userNoteForm){removeClass(userNoteForm,'shrinked');addClass(userNote,'shrinked');}
scrollToElement(userNoteForm);return false;},deleteResponse:function(){var form=$('user_note_form').getElementsByTagName('form')[0];var textarea=form['note'];textarea.innerHTML='';form.submit();}
}
if(typeof deconcept=="undefined"){var deconcept=new Object();}
if(typeof deconcept.util=="undefined"){deconcept.util=new Object();}
if(typeof deconcept.SWFObjectUtil=="undefined"){deconcept.SWFObjectUtil=new Object();}
deconcept.SWFObject=function(_1,id,w,h,_5,c,_7,_8,_9,_a)
{if(!document.getElementById)return;this.DETECT_KEY=_a ?_a:"detectflash";this.skipDetect=deconcept.util.getRequestParameter(this.DETECT_KEY);this.params=new Object();this.variables=new Object();this.attributes=new Array();if(_1){ this.setAttribute("swf",_1);}
if(id){ this.setAttribute("id",id);}
if(w){ this.setAttribute("width",w);}
if(h){ this.setAttribute("height",h);}
if(_5){ this.setAttribute("version",new deconcept.PlayerVersion(_5.toString().split(".")));}
this.installedVer=deconcept.SWFObjectUtil.getPlayerVersion();if(!window.opera&&document.all&&this.installedVer.major > 7)
{deconcept.SWFObject.doPrepUnload=true;}
if(c){ this.addParam("bgcolor",c);}
var q=_7 ?_7:"high";this.addParam("quality",q);this.setAttribute("useExpressInstall",false);this.setAttribute("doExpressInstall",false);var _c=_8 ?_8:window.location;this.setAttribute("xiRedirectUrl",_c);this.setAttribute("redirectUrl","");if(_9){ this.setAttribute("redirectUrl",_9);}
}
deconcept.SWFObject.prototype ={useExpressInstall:function(_d)
{this.xiSWFPath=!_d ?"expressinstall.swf":_d;this.setAttribute("useExpressInstall",true);},setAttribute:function(_e,_f)
{this.attributes[_e]=_f;},getAttribute:function(_10)
{return this.attributes[_10] ?this.attributes[_10]:'';},addParam:function(_11,_12)
{this.params[_11]=_12;},getParams:function()
{return this.params;},addVariable:function(_13,_14)
{this.variables[_13]=_14;},getVariable:function(_15)
{return this.variables[_15];},getVariables:function()
{return this.variables;},getVariablePairs:function()
{ var _16=new Array(),key,_18=this.getVariables();for(key in _18)
{_16[_16.length]=key+"="+_18[key];}
return _16;},getSWFHTML:function()
{var _19="";if(navigator.plugins&&navigator.mimeTypes&&navigator.mimeTypes.length)
{if(this.getAttribute("doExpressInstall"))
{this.addVariable("MMplayerType","PlugIn");this.setAttribute("swf",this.xiSWFPath);}
_19="<embed type=\"application/x-shockwave-flash\" src=\""+this.getAttribute("swf")+"\" width=\""+this.getAttribute("width")+"\" height=\""+this.getAttribute("height")+"\" style=\""+this.getAttribute("style")+"\"";_19+=" id=\""+this.getAttribute("id")+"\" name=\""+this.getAttribute("id")+"\" ";var _1a=this.getParams();for(var key in _1a){_19+=[key]+"=\""+_1a[key]+"\" ";}var _1c=this.getVariablePairs().join("&");if(_1c.length>0){_19+="flashvars=\""+_1c+"\"";}_19+="/>";}
else
{if(this.getAttribute("doExpressInstall"))
{this.addVariable("MMplayerType","ActiveX");this.setAttribute("swf",this.xiSWFPath);}
_19="<object id=\""+this.getAttribute("id")+"\" classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" width=\""+this.getAttribute("width")+"\" height=\""+this.getAttribute("height")+"\" style=\""+this.getAttribute("style")+"\">";_19+="<param name=\"movie\" value=\""+this.getAttribute("swf")+"\" />";var _1d=this.getParams();for(var key in _1d)
{_19+="<param name=\""+key+"\" value=\""+_1d[key]+"\" />";}
var _1f=this.getVariablePairs().join("&");if(_1f.length > 0)
{_19+="<param name=\"flashvars\" value=\""+_1f+"\" />";}
_19+="</object>";}
return _19;},write:function(_20)
{if(this.getAttribute("useExpressInstall"))
{var _21=new deconcept.PlayerVersion([6,0,65]);if(this.installedVer.versionIsValid(_21)&& !this.installedVer.versionIsValid(this.getAttribute("version")))
{this.setAttribute("doExpressInstall",true);this.addVariable("MMredirectURL",escape(this.getAttribute("xiRedirectUrl")));document.title=document.title.slice(0,47)+"-Flash Player Installation";this.addVariable("MMdoctitle",document.title);}
}
if(this.skipDetect||this.getAttribute("doExpressInstall")|| this.installedVer.versionIsValid(this.getAttribute("version")))
{var n=(typeof _20=="string")?document.getElementById(_20):_20;n.innerHTML=this.getSWFHTML();return true;}
else{if(this.getAttribute("redirectUrl")!=""){document.location.replace(this.getAttribute("redirectUrl"));}}
return false;}
};deconcept.SWFObjectUtil.getPlayerVersion=function()
{var _23=new deconcept.PlayerVersion([0,0,0]);if(navigator.plugins&&navigator.mimeTypes.length)
{var x=navigator.plugins["Shockwave Flash"];if(x&&x.description)
{_23=new deconcept.PlayerVersion(x.description.replace(/([a-zA-Z]|\s)+/,"").replace(/(\s+r|\s+b[0-9]+)/,".").split("."));}
}
else
{if(navigator.userAgent&&navigator.userAgent.indexOf("Windows CE")>=0)
{var axo=1,_26=3;while(axo)
{try
{++_26;axo=new ActiveXObject("ShockwaveFlash.ShockwaveFlash."+_26);_23=new deconcept.PlayerVersion([_26,0,0]);}
catch(e)
{axo=null;}
}
}
else
{try
{var axo=new ActiveXObject("ShockwaveFlash.ShockwaveFlash.7");}
catch(e)
{try
{var axo=new ActiveXObject("ShockwaveFlash.ShockwaveFlash.6");_23=new deconcept.PlayerVersion([6,0,21]);axo.AllowScriptAccess="always";}
catch(e)
{if(_23.major==6)return _23;}
try
{axo=new ActiveXObject("ShockwaveFlash.ShockwaveFlash");}
catch(e){}
}
if(axo!=null)
{_23=new deconcept.PlayerVersion(axo.GetVariable("$version").split(" ")[1].split(","));}
}
}
return _23;};deconcept.PlayerVersion=function(_29)
{this.major =_29[0]!=null ?parseInt(_29[0]):0;this.minor =_29[1]!=null ?parseInt(_29[1]):0;this.rev=_29[2]!=null ?parseInt(_29[2]):0;};deconcept.PlayerVersion.prototype.versionIsValid=function(fv)
{if(this.major<fv.major)return false;if(this.major > fv.major)return true;if(this.minor<fv.minor)return false;if(this.minor > fv.minor)return true;if(this.rev<fv.rev)return false;return true;}
deconcept.util ={getRequestParameter:function(_2b)
{var q=document.location.search||document.location.hash;if(_2b==null)return q;if(q)
{var _2d=q.substring(1).split("&");for(var i=0;i<_2d.length;i++)
{if(_2d[i].substring(0,_2d[i].indexOf("="))==_2b)
{return _2d[i].substring((_2d[i].indexOf("=")+1));}
}
}
return "";}
};deconcept.SWFObjectUtil.cleanupSWFs=function()
{var _2f=document.getElementsByTagName("OBJECT");for(var i=_2f.length-1;i >= 0;i--)
{_2f[i].style.display="none";for(var x in _2f[i])
{if(typeof _2f[i][x]=="function")
{_2f[i][x]=function(){};}
}
}
};if(deconcept.SWFObject.doPrepUnload)
{if(!deconcept.unloadSet)
{deconcept.SWFObjectUtil.prepUnload=function()
{__flash_unloadHandler=function(){};__flash_savedUnloadHandler=function(){};window.attachEvent("onunload",deconcept.SWFObjectUtil.cleanupSWFs);}
window.attachEvent("onbeforeunload",deconcept.SWFObjectUtil.prepUnload);deconcept.unloadSet=true;}
}
if(!document.getElementById&&document.all)
{document.getElementById=function(id)
{return document.all[id];}
}
var getQueryParamValue=deconcept.util.getRequestParameter;var FlashObject=deconcept.SWFObject;var SWFObject=deconcept.SWFObject;DDWYG={insertTagWithText:function(link,tagName){var startTag='<'+tagName+'>';var endTag='</'+tagName+'>';DDWYG.insertTag(link,startTag,endTag);return false;},insertList:function(link,tag){var startTag='<'+tag+'>\n';var endTag='\n</'+tag+'>';var repObj={findStr:'^(.+)',repStr:'<li>$1</li>' 
}
DDWYG.insertTag(link,startTag,endTag,repObj);return false;},insertLink:function(link){var href=prompt('Введите адрес ссылки','http://');if(href){DDWYG.insertTag(link,'<a href="'+href+'">','</a>');}
return false;},insertImage:function(link){var src=prompt('Введите ссылку на картинку','http://');if(src){DDWYG.insertTag(link,'<img src="'+src+'">','');}
return false;},insertVideo:function(link){var src=prompt('Введите ссылку на видео','http://');if(src){DDWYG.insertTag(link,'<video>'+src+'</video>','');}
return false;},insertUser:function(link){var login=prompt('Введите никнейм пользователя','');if(login){DDWYG.insertTag(link,'<dd user="'+login+'"/>','');}
return false;},insertDDcut:function(link){DDWYG.insertTag(link,'<ddcut />','');return false;},insertTag:function(link,startTag,endTag,repObj){var textareaParent=getParentByClassName(link,'editor');var textarea=textareaParent.getElementsByTagName('textarea')[0];textarea.focus();var scrtop=textarea.scrollTop;var cursorPos=DDWYG.getCursor(textarea);var txt_pre=textarea.value.substring(0,cursorPos.start);var txt_sel=textarea.value.substring(cursorPos.start,cursorPos.end);var txt_aft=textarea.value.substring(cursorPos.end);if(repObj){txt_sel=txt_sel.replace(/\r/g,'');txt_sel=txt_sel!='' ?txt_sel:' ';txt_sel=txt_sel.replace(new RegExp(repObj.findStr,'gm'),repObj.repStr);}
if(cursorPos.start==cursorPos.end){var nuCursorPos=cursorPos.start+startTag.length;}else{var nuCursorPos=String(txt_pre+startTag+txt_sel+endTag).length;}
textarea.value=txt_pre+startTag+txt_sel+endTag+txt_aft;DDWYG.setCursor(textarea,nuCursorPos,nuCursorPos);if(scrtop)textarea.scrollTop=scrtop;return false;},insertTagFromDropBox:function(link){DDWYG.insertTagWithText(link,link.value);link.selectedIndex=0;},insertObjectFromDropBox:function(link){DDWYG[link.value](link);link.selectedIndex=0;},insertTab:function(e,textarea){if(!e)e=window.event;if(e.keyCode)var keyCode=e.keyCode;else if(e.which)var keyCode=e.which;switch(e.type){case 'keydown':
if(keyCode==16){DDWYG.shift=true;}
break;case 'keyup':
if(keyCode==16){DDWYG.shift=false;}
break;}
textarea.focus();var cursorPos=DDWYG.getCursor(textarea);if(cursorPos.start==cursorPos.end){return true;}else if(keyCode==9&&!DDWYG.shift){var repObj={findStr:'^(.+)',repStr:'\t$1' 
}
DDWYG.insertTag(textarea,'','',repObj);return false;}else if(keyCode==9&&DDWYG.shift){var repObj={findStr:'^\t(.+)',repStr:'$1' 
}
DDWYG.insertTag(textarea,'','',repObj);return false;}
},getCursor:function(input){var result={start:0,end:0};if(input.setSelectionRange){result.start= input.selectionStart;result.end=input.selectionEnd;}else if(!document.selection){return false;}else if(document.selection&&document.selection.createRange){var range=document.selection.createRange();var stored_range=range.duplicate();stored_range.moveToElementText(input);stored_range.setEndPoint('EndToEnd',range);result.start=stored_range.text.length-range.text.length;result.end=result.start+range.text.length;}
return result;},setCursor:function(textarea,start,end){if(textarea.createTextRange){var range=textarea.createTextRange();range.move("character",start);range.select();}else if(textarea.selectionStart){textarea.setSelectionRange(start,end);}
}
}
var Paginator=function(paginatorHolderId,pagesTotal,pagesSpan,pageCurrent,baseUrl){if(!document.getElementById(paginatorHolderId)|| !pagesTotal||!pagesSpan)return false;this.inputData={paginatorHolderId:paginatorHolderId,pagesTotal:pagesTotal,pagesSpan:pagesSpan<pagesTotal ?pagesSpan:pagesTotal,pageCurrent:pageCurrent,baseUrl:baseUrl ?baseUrl:'/pages/'
};this.html={holder:null,table:null,trPages:null,
trScrollBar:null,tdsPages:null,scrollBar:null,scrollThumb:null,pageCurrentMark:null
};this.prepareHtml();this.initScrollThumb();this.initPageCurrentMark();this.initEvents();this.scrollToPageCurrent();this.checkIsFull();}
Paginator.prototype.prepareHtml=function(){this.html.holder=document.getElementById(this.inputData.paginatorHolderId);this.html.holder.innerHTML=this.makePagesTableHtml();this.html.table=this.html.holder.getElementsByTagName('table')[0];var trPages=this.html.table.getElementsByTagName('tr')[0];
this.html.tdsPages=trPages.getElementsByTagName('td');this.html.scrollBar=getElementsByClassName(this.html.table,'div','scroll_bar')[0];this.html.scrollThumb=getElementsByClassName(this.html.table,'div','scroll_thumb')[0];this.html.pageCurrentMark=getElementsByClassName(this.html.table,'div','current_page_mark')[0];}
Paginator.prototype.checkIsFull=function(){if(this.inputData.pagesSpan==this.inputData.pagesTotal){addClass(this.html.holder,'fullsize');return true;}else{return false;}
}
Paginator.prototype.makePagesTableHtml=function(){var tdWidth=(100 / this.inputData.pagesSpan)+'%';var html=''+'<table width="100%">'+'<tr>' 
for(var i=1;i<=this.inputData.pagesSpan;i++){html+='<td width="'+tdWidth+'"></td>';}
html+=''+
'</tr>'+'<tr>'+'<td colspan="'+this.inputData.pagesSpan+'">'+'<div class="scroll_bar">'+
'<div class="scroll_trough"></div>'+
'<div class="scroll_thumb">'+
'<div class="scroll_knob"></div>'+
'</div>'+
'<div class="current_page_mark"></div>'+
'</div>'+'</td>'+'</tr>'+'</table>';return html;}
Paginator.prototype.initScrollThumb=function(){this.html.scrollThumb.widthMin='8';
this.html.scrollThumb.widthPercent=this.inputData.pagesSpan/this.inputData.pagesTotal * 100;this.html.scrollThumb.xPosPageCurrent=(this.inputData.pageCurrent-Math.round(this.inputData.pagesSpan/2))/this.inputData.pagesTotal * this.html.table.offsetWidth;this.html.scrollThumb.xPos=this.html.scrollThumb.xPosPageCurrent;this.html.scrollThumb.xPosMin=0;this.html.scrollThumb.xPosMax;this.html.scrollThumb.widthActual;this.setScrollThumbWidth();}
Paginator.prototype.setScrollThumbWidth=function(){this.html.scrollThumb.style.width=this.html.scrollThumb.widthPercent+"%";this.html.scrollThumb.widthActual=this.html.scrollThumb.offsetWidth;if(this.html.scrollThumb.widthActual<this.html.scrollThumb.widthMin){this.html.scrollThumb.style.width=this.html.scrollThumb.widthMin+'px';}
this.html.scrollThumb.xPosMax=this.html.table.offsetWidth-this.html.scrollThumb.widthActual;}
Paginator.prototype.moveScrollThumb=function(){this.html.scrollThumb.style.left=this.html.scrollThumb.xPos+"px";}
Paginator.prototype.initPageCurrentMark=function(){this.html.pageCurrentMark.widthMin='3';this.html.pageCurrentMark.widthPercent=100 / this.inputData.pagesTotal;this.html.pageCurrentMark.widthActual;this.setPageCurrentPointWidth();this.movePageCurrentPoint();}
Paginator.prototype.setPageCurrentPointWidth=function(){this.html.pageCurrentMark.style.width=this.html.pageCurrentMark.widthPercent+'%';this.html.pageCurrentMark.widthActual=this.html.pageCurrentMark.offsetWidth;if(this.html.pageCurrentMark.widthActual<this.html.pageCurrentMark.widthMin){this.html.pageCurrentMark.style.width=this.html.pageCurrentMark.widthMin+'px';}
}
Paginator.prototype.movePageCurrentPoint=function(){if(this.html.pageCurrentMark.widthActual<this.html.pageCurrentMark.offsetWidth){this.html.pageCurrentMark.style.left=(this.inputData.pageCurrent-1)/this.inputData.pagesTotal * this.html.table.offsetWidth-this.html.pageCurrentMark.offsetWidth/2+"px";}else{this.html.pageCurrentMark.style.left=(this.inputData.pageCurrent-1)/this.inputData.pagesTotal * this.html.table.offsetWidth+"px";}
}
Paginator.prototype.initEvents=function(){var _this=this;this.html.scrollThumb.onmousedown=function(e){if(!e)var e=window.event;e.cancelBubble=true;if(e.stopPropagation)e.stopPropagation();var dx=getMousePosition(e).x-this.xPos;document.onmousemove=function(e){if(!e)var e=window.event;_this.html.scrollThumb.xPos=getMousePosition(e).x-dx;_this.moveScrollThumb();_this.drawPages();}
document.onmouseup=function(){document.onmousemove=null;_this.enableSelection();}
_this.disableSelection();}
this.html.scrollBar.onmousedown=function(e){if(!e)var e=window.event;if(matchClass(_this.paginatorBox,'fullsize'))return;_this.html.scrollThumb.xPos=getMousePosition(e).x-getPageX(_this.html.scrollBar)-_this.html.scrollThumb.offsetWidth/2;_this.moveScrollThumb();_this.drawPages();}
addEvent(window,'resize',function(){Paginator.resizePaginator(_this)});}
Paginator.prototype.drawPages=function(){var percentFromLeft=this.html.scrollThumb.xPos/(this.html.table.offsetWidth);var cellFirstValue=Math.round(percentFromLeft * this.inputData.pagesTotal);var html="";if(cellFirstValue<1){cellFirstValue=1;this.html.scrollThumb.xPos=0;this.moveScrollThumb();}else if(cellFirstValue >= this.inputData.pagesTotal-this.inputData.pagesSpan){cellFirstValue=this.inputData.pagesTotal-this.inputData.pagesSpan+1;this.html.scrollThumb.xPos=this.html.table.offsetWidth-this.html.scrollThumb.offsetWidth;this.moveScrollThumb();}
for(var i=0;i<this.html.tdsPages.length;i++){var cellCurrentValue=cellFirstValue+i;if(cellCurrentValue==this.inputData.pageCurrent){html="<span>"+"<strong>"+cellCurrentValue+"</strong>"+"</span>";}else{html="<span>"+"<a href='"+this.inputData.baseUrl+cellCurrentValue+"'>"+cellCurrentValue+"</a>"+"</span>";}
this.html.tdsPages[i].innerHTML=html;}
}
Paginator.prototype.scrollToPageCurrent=function(){this.html.scrollThumb.xPosPageCurrent=(this.inputData.pageCurrent-Math.round(this.inputData.pagesSpan/2))/this.inputData.pagesTotal * this.html.table.offsetWidth;this.html.scrollThumb.xPos=this.html.scrollThumb.xPosPageCurrent;this.moveScrollThumb();this.drawPages();}
Paginator.prototype.disableSelection=function(){document.onselectstart=function(){return false;}
this.html.scrollThumb.focus();}
Paginator.prototype.enableSelection=function(){document.onselectstart=function(){return true;}
}
Paginator.resizePaginator=function(paginatorObj){paginatorObj.setPageCurrentPointWidth();paginatorObj.movePageCurrentPoint();paginatorObj.setScrollThumbWidth();paginatorObj.scrollToPageCurrent();}
var insertTag=function(link,tagFieldId){var tagFields;if(tagFieldId){tagField=$(tagFieldId);}else{tagField=$('tags');}
if(!tagField)return false;var tag=link.innerHTML;if(tagField.value.toLowerCase().indexOf(tag.toLowerCase())!= -1)return false;var tagArray=[];if(tagField.value.match(/\S+/)){tagField.value=tagField.value.replace(/,\s+/g,',');tagField.value=tagField.value.replace(/,$/g,'');tagArray=tagField.value.split(',');}
tagArray[tagArray.length]=tag;str=','+' ';tagField.value=tagArray.join(str)+str;tagField.focus();return false;}
var insertTerm=function(term,field){field.value=term
return false;}
scrollToElement=function(element){if(!element)return false;var winScroll=window.pageYOffset||document.documentElement.scrollTop||document.body.scrollTop;var elementOffset=getPageY(element);var distanseStart=elementOffset-winScroll;var distansePeak=Math.abs(distanseStart)/15;window.scrollBy(0,Math.abs(distanseStart)/distanseStart * 5);makeScroll(element,distanseStart,distansePeak,distanseStart);return false;}
makeScroll=function(element,distanseStart,distansePeak,distansePrev){var winScroll=window.pageYOffset||document.documentElement.scrollTop||document.body.scrollTop;var elementOffset=getPageY(element);var distanseCurrent=elementOffset-winScroll;var distanseInPi=distanseCurrent/Math.abs(distanseStart/Math.PI);if((Math.abs(distanseCurrent)< 10)|| distanseCurrent==distansePrev){window.scrollBy(0,distanseCurrent);return false;}else{window.scrollBy(0,Math.sin(distanseInPi)* distansePeak);setTimeout(function(){makeScroll(element,distanseStart,distansePeak,distanseCurrent)},1);}
return false;}
createScrollLink=function(link){if(link.href.match(/scrollTo:/))return true;var linkParts=link.href.split('#');link.href=linkParts[0]+'#scrollTo:'+linkParts[1];return true;}
var imageResizer={resizeAllImages:function(container,childClassName){if(!childClassName)childClassName='user_content';var comments_holders=getElementsByClassName(container,'*',childClassName);for(var i=0;i<comments_holders.length;i++){imageResizer.resizeImages(comments_holders[i]);}
},resizeImages:function(parent){var imgs=parent.getElementsByTagName('img');for(var i=0;i<imgs.length;i++){imageResizer.checkResize(imgs[i],parent);}
},checkResize:function(img,parent){if(img.offsetWidth > parent.offsetWidth){imageResizer.makeResize(img,parent);}else{img.onload=function(){var hiddenParentComment=getParentByClassName(parent,'comment_block');var hiddenParentEvent=getParentByClassName(parent,'event_old');if(hiddenParentComment){if(matchClass(hiddenParentComment,'show_anycase')){imageResizer.checkResizeOnload(img,parent);}else{ 
addClass(hiddenParentComment,'show_anycase');imageResizer.checkResizeOnload(img,parent);removeClass(hiddenParentComment,'show_anycase');}
}else if(hiddenParentEvent){removeClass(hiddenParentEvent,'event_old');imageResizer.checkResizeOnload(img,parent);addClass(hiddenParentEvent,'event_old');}else{imageResizer.checkResizeOnload(img,parent);}
}
}
},checkResizeOnload:function(img,parent){if(img.offsetWidth > parent.offsetWidth){imageResizer.makeResize(img,parent);}
},makeResize:function(img,parent){img.style.width=parent.offsetWidth+'px';addClass(img,'is_zoomed');var parentTest=getParentByTagName(img,'a');if(!parentTest&&typeof document.getElementsByTagName('body')[0].style.maxWidth!='undefined'){img.title='Увеличить изображение';img.onclick=function(){if(this.was_zoomed){parent.style.overflow='hidden';this.style.width=parent.offsetWidth+'px';this.was_zoomed=false;this.title='Увеличить изображение';}else{parent.style.overflow='visible';this.style.width='auto';this.was_zoomed=true;this.title='Уменьшить изображение';}
}
}
}
}
var moderateComment={jsonResponse:{error:{handler:'showError'
},comments:{handler:'showVote'
}
},voteComment:function(link,commentId,voteType){var url=window.SITE_URL+'ajax/'+voteType+'/?'+'id='+commentId;var params={link:link
}
moderateComment.setLoading(params);ajaxGet(url,moderateComment.voteAgainstOnload,params
)
return false;},voteAgainstOnload:function(ajaxObj,params){moderateComment.clearLoading(params);if(ajaxObj&&ajaxObj.responseText){var json=null;var errorServer=null;try{eval('json='+ajaxObj.responseText);}catch(e){alert('Произошла ошибка на сервере');errorServer=true;}
if(!errorServer){for(var prop in json){if(moderateComment.jsonResponse[prop].handler){moderateComment[moderateComment.jsonResponse[prop].handler](json,params);}
}
}
}
},openTrashedComment:function(link){var parent=getParentByClassName(link,'comment_block');if(!parent)parent=getParentByClassName(link,'comments_item');if(matchClass(parent,'comment_trashed')){removeClass(parent,'comment_trashed');imageResizer.resizeAllImages(parent);}else{addClass(parent,'comment_trashed');if($('comment_form')){commentForm.cancelComment(link);}
}
return false;},showError:function(json,params){moderateComment.clearLoading(params);alert(json.error);},showVote:function(json,params){var comment=json.comments.commentModified;var commentId=comment[0];var commentHtml=comment[1];var div=document.createElement('div');div.innerHTML=commentHtml;var commentNew=getElementsByClassName(div,'*','comment_block')[0];var commentReplaced=$('comment_'+commentId);addClass(commentNew,'show_anycase');if(matchClass(commentReplaced,'comment_new')){addClass(commentNew,'comment_new');};commentReplaced.parentNode.insertBefore(commentNew,commentReplaced);commentReplaced.parentNode.removeChild(commentReplaced);},setLoading:function(params){var parent=getParentByClassName(params.link,'comment_block');var commentHead=getElementsByClassName(parent,'*','comment_head')[0];addClass(commentHead,'loading');var loader=null;var loaders=getElementsByClassName(commentHead,'img','ajax_preloader');if(loaders.length==0){loader=$('common_preloader').cloneNode(true);loader.id='';commentHead.appendChild(loader);}
},clearLoading:function(params){var parent=getParentByClassName(params.link,'comment_block');var commentHead=getElementsByClassName(parent,'*','comment_head')[0];removeClass(commentHead,'loading');}
}
var moderateResponse={jsonResponse:{error:{handler:'showError'
},result:{handler:'showVote'
}
},voteResponse:function(link,responseId,voteType){var url=window.SITE_URL+'ajax/'+voteType+'/?'+'pk_response='+responseId;var responseHead=getParentByClassName(link,'comment_head');if(matchClass(responseHead,'loading'))return false;var responseBlock=getParentByClassName(link,'comment_block');var params={link:link,responseHead:responseHead,responseBlock:responseBlock
}
moderateResponse.setLoading(params);ajaxGet(url,moderateResponse.voteResponseOnload,params
)
return false;},voteResponseOnload:function(ajaxObj,params){moderateResponse.clearLoading(params);if(ajaxObj&&ajaxObj.responseText){var json=null;var errorServer=null;try{eval('json='+ajaxObj.responseText);}catch(e){alert('Произошла ошибка на сервере');errorServer=true;}
if(!errorServer){for(var prop in json){if(moderateResponse.jsonResponse[prop]&&moderateResponse.jsonResponse[prop].handler){moderateResponse[moderateResponse.jsonResponse[prop].handler](json,params);}
}
}
}
},showError:function(json,params){moderateResponse.clearLoading(params);alert(json.error);},showVote:function(json,params){var responseHead=json.result.head;var responseTrash=json.result.trash;var responseIsTrash=json.result.is_trash;var div=document.createElement('div');div.innerHTML=responseHead;var responseHeadNew=getElementsByClassName(div,'*','comment_head')[0];var responseHeadReplaced=params.responseHead;responseHeadReplaced.parentNode.insertBefore(responseHeadNew,responseHeadReplaced);responseHeadReplaced.parentNode.removeChild(responseHeadReplaced);var responseTrashReplaced=getElementsByClassName(params.responseBlock,'*','trashed_status');if(responseTrashReplaced.length!=0){responseTrashReplaced[0].parentNode.removeChild(responseTrashReplaced[0]);}
if(responseTrash!=''){div.innerHTML=responseTrash;var responseTrashNew=getElementsByClassName(div,'*','trashed_status')[0];responseHeadNew.parentNode.insertBefore(responseTrashNew,responseHeadNew.nextSibling);}
if(responseIsTrash==1){addClass(params.responseBlock,'comment_trashed');}else{removeClass(params.responseBlock,'comment_trashed');}
},setLoading:function(params){addClass(params.responseHead,'loading');var loader=null;var loaders=getElementsByClassName(params.responseHead,'img','ajax_preloader');if(loaders.length==0){loader=$('common_preloader').cloneNode(true);loader.id='';params.responseHead.appendChild(loader);}
},clearLoading:function(params){removeClass(params.responseHead,'loading');},openTrashedResponse:function(link){var parent=getParentByClassName(link,'comment_block');if(matchClass(parent,'comment_trashed')){removeClass(parent,'comment_trashed');imageResizer.resizeAllImages(parent);}else{addClass(parent,'comment_trashed');}
return false;}
}
var setRelation={jsonResponse:{error:{handler:'showError'
},result:{handler:'showResult'
},groupVoteResult:{handler:'showGroupVoteResult'
}
},sendData:function(link,itemId,relationType,reason){var parentGlobal=getParentByClassName(link,'flexible_content_parent');if(parentGlobal&&matchClass(parentGlobal,'loading')){return false;}
var flexibleContent=getParentByClassName(link,'flexible_content');var url=window.SITE_URL+
'ajax/'+relationType+'/?'+'id='+itemId;if(reason)url+='&reason='+reason;var params={link:link,parentGlobal:parentGlobal,flexibleContent:flexibleContent
}
setRelation.setLoading(params);ajaxGet(url,setRelation.sendDataOnload,params
)
return false;},sendDataToServer:function(link,relationType,paramsObj,showPreloader){var parentGlobal=getParentByClassName(link,'flexible_content_parent');if(parentGlobal&&matchClass(parentGlobal,'loading')){return false;}
var flexibleContent=getParentByClassName(link,'flexible_content');var url=window.SITE_URL+'ajax/'+relationType+'/?';for(var i in paramsObj){url+=i+'='+paramsObj[i]+'&';}
var params={link:link,parentGlobal:parentGlobal,flexibleContent:flexibleContent
}
setRelation.setLoading(params,showPreloader);ajaxGet(url,setRelation.sendDataOnload,params
)
return false;},sendDataOnload:function(ajaxObj,params){setRelation.clearLoading(params);if(ajaxObj&&ajaxObj.responseText){var json=null;var errorServer=null;try{eval('json='+ajaxObj.responseText);}catch(e){alert('Произошла ошибка на сервере');errorServer=true;}
if(!errorServer){for(var prop in json){if(setRelation.jsonResponse[prop]&&setRelation.jsonResponse[prop].handler){setRelation[setRelation.jsonResponse[prop].handler](json,params);}
}
}
}
},showResult:function(json,params){params.flexibleContent.innerHTML=json.result;},showGroupVoteResult:function(json,params){if(json.groupVoteResult==0){var parent=params.parentGlobal;var giftBox=getParentByClassName(parent,'gift_list_item');addClass(giftBox,'hidden');}
},showError:function(json,params){setRelation.clearLoading(params);alert(json.error);},setLoading:function(params,showPreloader){if(showPreloader&&params.flexibleContent){var loader=null;loader=$('common_preloader').cloneNode(true);loader.removeAttribute('id');params.flexibleContent.appendChild(loader);}
if(params.parentGlobal){addClass(params.parentGlobal,'loading');}
},clearLoading:function(params){if(params.parentGlobal){removeClass(params.parentGlobal,'loading');}
}
}
commentVoterMaker={make:function(link){var parent=getParentByClassName(link,'voter_holder');if(matchClass(parent,'voter_was_made')){return false
}
var parentGlobal=getParentByClassName(link,'comment_block');var parentGlobalId=parentGlobal.id.split('_')[1];var voter=$('comment_voter').cloneNode(true);voter.id='';commentVoterMaker.addEvents(voter,parentGlobalId);commentVoterMaker.drawVoter(parent,voter);addClass(parent,'voter_was_made');},drawVoter:function(parent,voter){parent.appendChild(voter);},addEvents:function(voter,parentGlobalId){var voterLike=getElementsByClassName(voter,'*','like')[0];var voterLikeLink=voterLike.getElementsByTagName('a')[0];voterLikeLink.onclick=function(){return setRelation.sendDataToServer(this,'comment_like',{id:parentGlobalId,v:1},true);}
var voterDislike=getElementsByClassName(voter,'*','dislike')[0];var voterDislikeLink=voterDislike.getElementsByTagName('a')[0];voterDislikeLink.onclick=function(){return setRelation.sendDataToServer(this,'comment_like',{id:parentGlobalId,v:-1},true);}
}
}
var setDisplay={jsonResponse:{error:{handler:'showError'
},result:{handler:'showResult'
}
},actionType:{contact_remove:'contactRemove',contact_events_show:'contactEventsShow',contact_events_hide:'contactEventsHide',contact_friendship_approve:'contactFriendshipApprove',contact_friendship_reject:'contactFriendshipReject'
},sendData:function(link,itemId,actionType){var flexibleContent=getParentByClassName(link,'flexible_content');if(flexibleContent&&matchClass(flexibleContent,'loading')){return false;}
var url=window.SITE_URL+
'ajax/'+actionType+'/?'+'id='+itemId;var params={link:link,flexibleContent:flexibleContent,actionType:actionType
}
setDisplay.setLoading(params);ajaxGet(url,setDisplay.sendDataOnload,params
)
return false;},sendDataOnload:function(ajaxObj,params){setDisplay.clearLoading(params);if(ajaxObj&&ajaxObj.responseText){var json=null;var errorServer=null;try{eval('json='+ajaxObj.responseText);}catch(e){alert('Произошла ошибка на сервере');errorServer=true;}
if(!errorServer){for(var prop in json){if(setDisplay.jsonResponse[prop]&&setDisplay.jsonResponse[prop].handler){setDisplay[setDisplay.jsonResponse[prop].handler](json,params);}
}
}
}
},showResult:function(json,params){if(json.result==1){setDisplay[setDisplay.actionType[params.actionType]](params);}
},showError:function(json,params){setDisplay.clearLoading(params);alert(json.error);},setLoading:function(params){if(params.flexibleContent){addClass(params.flexibleContent,'loading');}
},clearLoading:function(params){if(params.flexibleContent){removeClass(params.flexibleContent,'loading');}
},contactRemove:function(params){addClass(params.flexibleContent,'contact_remove');},contactEventsShow:function(params){removeClass(params.flexibleContent,'contact_events_hide');addClass(params.flexibleContent,'contact_events_show');},contactEventsHide:function(params){removeClass(params.flexibleContent,'contact_events_show');addClass(params.flexibleContent,'contact_events_hide');},contactFriendshipApprove:function(params){removeClass(params.flexibleContent,'contact_was_declined');addClass(params.flexibleContent,'contact_was_accepted');},contactFriendshipReject:function(params){removeClass(params.flexibleContent,'contact_was_accepted');addClass(params.flexibleContent,'contact_was_declined');}
}
var supportForm={getCatDescription:function(selectField){var url=window.SITE_URL+'ajax/get_support_category/'+'?'+'pk_category='+selectField.value;var params={selectField:selectField
}
selectField.disabled=true;ajaxGet(url,supportForm.getCatDescriptionOnload,params
)
},getCatDescriptionOnload:function(ajaxObj,params){params.selectField.disabled=false;var catDescriptionHolder=$('cat_description_holder');if(!catDescriptionHolder)return false;if(ajaxObj&&ajaxObj.responseText){var json=null
var errorServer=null;try{eval('json='+ajaxObj.responseText);}catch(e){alert('Произошла ошибка на сервере');errorServer=true;}
}
if(!errorServer){catDescriptionHolder.innerHTML=json.result;}
}
}
var categoryHint={show:function(link){var parent=getParentByClassName(link,'cat_holder');addClass(parent,'cat_description_show');},hide:function(link){var parent=getParentByClassName(link,'cat_holder');removeClass(parent,'cat_description_show');}
}
var giftInteraction={timer:null,prepareMenu:function(link){giftInteraction.showMenu(link);},showMenu:function(link){var parent=getParentByClassName(link,'gift_interaction_holder');addClass(parent,'show_interaction_menu');addClass(parent,'menu_is_active');},hideMenu:function(e,link){if(e.relatedTarget){var where=e.relatedTarget;if(matchClass(where,'gift_interaction_holder'))return;if(where.nodeType==3)where=where.parentNode;var children=link.getElementsByTagName('*');for(var i=0;i<children.length;i++){if(where==children[i]){return;}
}
}else if(e.toElement&&link.contains(e.toElement)){return;}
removeClass(link,'menu_is_active');giftInteraction.timer=setTimeout(function(){giftInteraction.hideMenuAtAll(link)},500);
},hideMenuAtAll:function(link){if(matchClass(link,'menu_is_active')){return false;}
removeClass(link,'show_interaction_menu');removeClass(link,'expand_interaction_menu');},expandMenu:function(link){var parent=getParentByClassName(link,'gift_interaction_holder');addClass(parent,'expand_interaction_menu');addClass(parent,'menu_is_active');return false;}
}
var viewMode={setMode:function(){var viewModeCookie=readCookie('viewMode');if(!viewModeCookie){createCookie('viewMode',1,30);viewMode.setFashionMode();}else{eraseCookie('viewMode');viewMode.setClassicMode();}
return false;},setFashionMode:function(){var body=document.getElementsByTagName('body')[0];addClass(body,'view_mode_fashion');},setClassicMode:function(){var body=document.getElementsByTagName('body')[0];removeClass(body,'view_mode_fashion');}
}
thankInteraction={timer:null,showButton:function(link){var parent=getParentByClassName(link,'thanks_illustrations_item');addClass(parent,'show_thank_delete_btn');addClass(parent,'menu_is_active');},hideButton:function(e,link){if(e.relatedTarget){var where=e.relatedTarget;if(matchClass(where,'thanks_illustrations_item'))return;if(where.nodeType==3)where=where.parentNode;var children=link.getElementsByTagName('*');for(var i=0;i<children.length;i++){if(where==children[i]){return;}
}
}else if(e.toElement&&link.contains(e.toElement)){return;}
removeClass(link,'menu_is_active');thankInteraction.timer=setTimeout(function(){thankInteraction.hideButtonAtAll(link)},500);
},hideButtonAtAll:function(link){if(matchClass(link,'menu_is_active')){return false;}
removeClass(link,'show_thank_delete_btn');},deleteImage:function(link,thankId,fileId){var parent=getParentByClassName(link,'thanks_illustrations_item');thankInteraction.sendData(parent,thankId,fileId);return false;},sendData:function(parent,thankId,fileId){if(matchClass(parent,'loading')){return false;}
var url=window.SITE_URL+
'ajax/thank_image_delete/?'+'pk_thank='+thankId+'&'+'pk_file='+fileId;var params={parent:parent
}
addClass(parent,'loading');ajaxGet(url,thankInteraction.sendDataOnload,params
)
return false;},sendDataOnload:function(ajaxObj,params){var parent=params.parent;removeClass(parent,'loading');if(ajaxObj&&ajaxObj.responseText){var json=null;var errorServer=null;try{eval('json='+ajaxObj.responseText);}catch(e){alert('Произошла ошибка на сервере');errorServer=true;}
if(!errorServer){if(json==1){parent.parentNode.removeChild(parent);}else{alert('Невозможно удалить');}
}
}
}
}
