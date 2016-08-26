function copyToClipboard(t){if(window.clipboardData&&window.clipboardData.setData)return clipboardData.setData("Text",t);if(document.queryCommandSupported&&document.queryCommandSupported("copy")){var n=document.createElement("textarea");n.textContent=t,n.style.position="fixed",document.body.appendChild(n),n.select();try{return document.execCommand("copy")}catch(e){return!1}finally{document.body.removeChild(n)}}}var KleisAccount=function(t,n){this.minLength=3,!t||t<this.minLength?this.chunkLen=this.minLength:this.chunkLen=t,!n||n<this.minLength?this.saltLen=this.minLength:this.saltLen=n};KleisAccount.prototype.generate=function(t,n){var e=t.removeAccents().replace(/[^A-Z|^0-9]/gi,"").toLowerCase(),r=n.removeAccents().replace(/[^A-Z|^0-9]/gi,"").toLowerCase(),s=e.substr(0,this.chunkLen),o=r.substr(0,this.chunkLen);if(s.length<this.chunkLen){var i=this.chunkLen+(this.chunkLen-s.length);r.length>=i&&(o=r.substr(0,i))}if(o.length<this.chunkLen){var i=this.chunkLen+(this.chunkLen-o.length);e.length>=i&&(s=e.substr(0,i))}var i=this.saltLen+(this.chunkLen-s.length)+(this.chunkLen-o.length),h=new RandomPassword,g=h.create(i,h.chrNumbers);return s+o+g};var KleisPassword=function(t){this.minLength=8,!t||t<this.minLength?this.length=this.minLength:this.length=chunkLen};KleisPassword.prototype.generate=function(){var t=new RandomPassword,n=t.chrLower+t.chrNumbers;return t.create(this.length,n)};var RandomPassword=function(){this.chrLower="abcdefghjkmnpqrst",this.chrUpper="ABCDEFGHJKMNPQRST",this.chrNumbers="23456789",this.chrSymbols="!#%&?+*_.,:;",this.maxLength=255,this.minLength=4};RandomPassword.prototype.create=function(t,n){var e=this.adjustLengthWithinLimits(t),r=this.secureCharacterCombination(n);return this.shufflePassword(this.assemblePassword(r,e))},RandomPassword.prototype.adjustLengthWithinLimits=function(t){return!t||t<this.minLength?this.minLength:t>this.maxLength?this.maxLength:t},RandomPassword.prototype.secureCharacterCombination=function(t){var n=this.chrLower+this.chrUpper+this.chrNumbers;return t&&""!=this.trim(t)&&this.containsAtLeast(t,[this.chrLower,this.chrUpper,this.chrNumbers,this.chrSymbols])?t:n},RandomPassword.prototype.assemblePassword=function(t,n){for(var e=this.chrNumbers.length,r=e-4,s=this.random(0,t.length-1),o="",i=0;i<n;i++){var h=this.random(r,e);s=s+h>t.length-1?this.random(0,t.length-1):s+h,o+=t[s]}return o},RandomPassword.prototype.shufflePassword=function(t){return t.split("").sort(function(){return.5-Math.random()}).join("")},RandomPassword.prototype.containsAtLeast=function(t,n){for(var e=0;e<n.length;e++)if(t.indexOf(n[e])!=-1)return!0;return!1},RandomPassword.prototype.random=function(t,n){return Math.floor(Math.random()*n+t)},RandomPassword.prototype.trim=function(t){return"function"!=typeof String.prototype.trim?t.replace(/^\s+|\s+$/g,""):t.trim()},String.prototype.removeAccents=function(){var t={A:/[AⒶＡÀÁÂẦẤẪẨÃĀĂẰẮẴẲȦǠÄǞẢÅǺǍȀȂẠẬẶḀĄ]/g,AA:/[Ꜳ]/g,AE:/[ÆǼǢ]/g,AO:/[Ꜵ]/g,AU:/[Ꜷ]/g,AV:/[ꜸꜺ]/g,AY:/[Ꜽ]/g,B:/[BⒷＢḂḄḆɃƂƁ]/g,C:/[CⒸＣĆĈĊČÇḈƇȻꜾ]/g,D:/[DⒹＤḊĎḌḐḒḎĐƋƊƉꝹ]/g,DZ:/[ǱǄ]/g,Dz:/[ǲǅ]/g,E:/[EⒺＥÈÉÊỀẾỄỂẼĒḔḖĔĖËẺĚȄȆẸỆȨḜĘḘḚƐƎ]/g,F:/[FⒻＦḞƑꝻ]/g,G:/[GⒼＧǴĜḠĞĠǦĢǤƓꞠꝽꝾ]/g,H:/[HⒽＨĤḢḦȞḤḨḪĦⱧⱵꞍ]/g,I:/[IⒾＩÌÍÎĨĪĬİÏḮỈǏȈȊỊĮḬƗ]/g,J:/[JⒿＪĴɈ]/g,K:/[KⓀＫḰǨḲĶḴƘⱩꝀꝂꝄꞢ]/g,L:/[LⓁＬĿĹĽḶḸĻḼḺŁȽⱢⱠꝈꝆꞀ]/g,LJ:/[Ǉ]/g,Lj:/[ǈ]/g,M:/[MⓂＭḾṀṂⱮƜ]/g,N:/[NⓃＮǸŃÑṄŇṆŅṊṈȠƝꞐꞤ]/g,NJ:/[Ǌ]/g,Nj:/[ǋ]/g,O:/[OⓄＯÒÓÔỒỐỖỔÕṌȬṎŌṐṒŎȮȰÖȪỎŐǑȌȎƠỜỚỠỞỢỌỘǪǬØǾƆƟꝊꝌ]/g,OI:/[Ƣ]/g,OO:/[Ꝏ]/g,OU:/[Ȣ]/g,P:/[PⓅＰṔṖƤⱣꝐꝒꝔ]/g,Q:/[QⓆＱꝖꝘɊ]/g,R:/[RⓇＲŔṘŘȐȒṚṜŖṞɌⱤꝚꞦꞂ]/g,S:/[SⓈＳẞŚṤŜṠŠṦṢṨȘŞⱾꞨꞄ]/g,T:/[TⓉＴṪŤṬȚŢṰṮŦƬƮȾꞆ]/g,TZ:/[Ꜩ]/g,U:/[UⓊＵÙÚÛŨṸŪṺŬÜǛǗǕǙỦŮŰǓȔȖƯỪỨỮỬỰỤṲŲṶṴɄ]/g,V:/[VⓋＶṼṾƲꝞɅ]/g,VY:/[Ꝡ]/g,W:/[WⓌＷẀẂŴẆẄẈⱲ]/g,X:/[XⓍＸẊẌ]/g,Y:/[YⓎＹỲÝŶỸȲẎŸỶỴƳɎỾ]/g,Z:/[ZⓏＺŹẐŻŽẒẔƵȤⱿⱫꝢ]/g,a:/[aⓐａẚàáâầấẫẩãāăằắẵẳȧǡäǟảåǻǎȁȃạậặḁąⱥɐ]/g,aa:/[ꜳ]/g,ae:/[æǽǣ]/g,ao:/[ꜵ]/g,au:/[ꜷ]/g,av:/[ꜹꜻ]/g,ay:/[ꜽ]/g,b:/[bⓑｂḃḅḇƀƃɓ]/g,c:/[cⓒｃćĉċčçḉƈȼꜿↄ]/g,d:/[dⓓｄḋďḍḑḓḏđƌɖɗꝺ]/g,dz:/[ǳǆ]/g,e:/[eⓔｅèéêềếễểẽēḕḗĕėëẻěȅȇẹệȩḝęḙḛɇɛǝ]/g,f:/[fⓕｆḟƒꝼ]/g,g:/[gⓖｇǵĝḡğġǧģǥɠꞡᵹꝿ]/g,h:/[hⓗｈĥḣḧȟḥḩḫẖħⱨⱶɥ]/g,hv:/[ƕ]/g,i:/[iⓘｉìíîĩīĭïḯỉǐȉȋịįḭɨı]/g,j:/[jⓙｊĵǰɉ]/g,k:/[kⓚｋḱǩḳķḵƙⱪꝁꝃꝅꞣ]/g,l:/[lⓛｌŀĺľḷḹļḽḻſłƚɫⱡꝉꞁꝇ]/g,lj:/[ǉ]/g,m:/[mⓜｍḿṁṃɱɯ]/g,n:/[nⓝｎǹńñṅňṇņṋṉƞɲŉꞑꞥ]/g,nj:/[ǌ]/g,o:/[oⓞｏòóôồốỗổõṍȭṏōṑṓŏȯȱöȫỏőǒȍȏơờớỡởợọộǫǭøǿɔꝋꝍɵ]/g,oi:/[ƣ]/g,ou:/[ȣ]/g,oo:/[ꝏ]/g,p:/[pⓟｐṕṗƥᵽꝑꝓꝕ]/g,q:/[qⓠｑɋꝗꝙ]/g,r:/[rⓡｒŕṙřȑȓṛṝŗṟɍɽꝛꞧꞃ]/g,s:/[sⓢｓßśṥŝṡšṧṣṩșşȿꞩꞅẛ]/g,t:/[tⓣｔṫẗťṭțţṱṯŧƭʈⱦꞇ]/g,tz:/[ꜩ]/g,u:/[uⓤｕùúûũṹūṻŭüǜǘǖǚủůűǔȕȗưừứữửựụṳųṷṵʉ]/g,v:/[vⓥｖṽṿʋꝟʌ]/g,vy:/[ꝡ]/g,w:/[wⓦｗẁẃŵẇẅẘẉⱳ]/g,x:/[xⓧｘẋẍ]/g,y:/[yⓨｙỳýŷỹȳẏÿỷẙỵƴɏỿ]/g,z:/[zⓩｚźẑżžẓẕƶȥɀⱬꝣ]/g},n=this;for(var e in t){var r=t[e];n=n.replace(r,e)}return n};