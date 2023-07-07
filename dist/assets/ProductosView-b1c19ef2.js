import{g as b,m as V,p as Y,u as C,a,e as L,I as m,f as Z,h as ee,i as ae,j as te,k as ne,l as se,n as ie,q as A,s as le,t as de,_ as re,o as _,c as T,w as s,v as ce,F as oe,x as ue,b as r,V as me,d as I}from"./index-900aba08.js";import{V as ve}from"./VMain-e70b6b69.js";import{b as fe,V as ge,a as P}from"./VRow-cfe7d217.js";import{c as v,V as S,a as pe}from"./VDivider-e4b5072d.js";import{m as D,d as y,e as ke,f as _e,g as ye,h as be,i as Ve,j as Ce,k as he,R as xe,u as Ae,l as Ie,n as Pe,o as Se,p as Be,q as Le,r as Te,s as De,a as we,L as Re,t as Fe,b as B}from"./VImg-805a399c.js";const qe=v("flex-grow-1","div","VSpacer");const w=b()({name:"VCardActions",props:V(),setup(e,i){let{slots:n}=i;return Y({VBtn:{variant:"text"}}),C(()=>{var t;return a("div",{class:["v-card-actions",e.class],style:e.style},[(t=n.default)==null?void 0:t.call(n)])}),{}}}),R=v("v-card-subtitle"),F=v("v-card-title"),je=L({appendAvatar:String,appendIcon:m,prependAvatar:String,prependIcon:m,subtitle:String,title:String,...V(),...D()},"VCardItem"),Ee=b()({name:"VCardItem",props:je(),setup(e,i){let{slots:n}=i;return C(()=>{var c;const t=!!(e.prependAvatar||e.prependIcon),f=!!(t||n.prepend),d=!!(e.appendAvatar||e.appendIcon),g=!!(d||n.append),p=!!(e.title||n.title),k=!!(e.subtitle||n.subtitle);return a("div",{class:["v-card-item",e.class],style:e.style},[f&&a("div",{key:"prepend",class:"v-card-item__prepend"},[n.prepend?a(y,{key:"prepend-defaults",disabled:!t,defaults:{VAvatar:{density:e.density,icon:e.prependIcon,image:e.prependAvatar}}},n.prepend):t&&a(S,{key:"prepend-avatar",density:e.density,icon:e.prependIcon,image:e.prependAvatar},null)]),a("div",{class:"v-card-item__content"},[p&&a(F,{key:"title"},{default:()=>{var l;return[((l=n.title)==null?void 0:l.call(n))??e.title]}}),k&&a(R,{key:"subtitle"},{default:()=>{var l;return[((l=n.subtitle)==null?void 0:l.call(n))??e.subtitle]}}),(c=n.default)==null?void 0:c.call(n)]),g&&a("div",{key:"append",class:"v-card-item__append"},[n.append?a(y,{key:"append-defaults",disabled:!d,defaults:{VAvatar:{density:e.density,icon:e.appendIcon,image:e.appendAvatar}}},n.append):d&&a(S,{key:"append-avatar",density:e.density,icon:e.appendIcon,image:e.appendAvatar},null)])])}),{}}}),q=v("v-card-text"),Ne=L({appendAvatar:String,appendIcon:m,disabled:Boolean,flat:Boolean,hover:Boolean,image:String,link:{type:Boolean,default:void 0},prependAvatar:String,prependIcon:m,ripple:{type:[Boolean,Object],default:!0},subtitle:String,text:String,title:String,...ke(),...V(),...D(),..._e(),...Z(),...ye(),...be(),...Ve(),...ee(),...Ce(),...ae(),...te(),...he({variant:"elevated"})},"VCard"),Me=b()({name:"VCard",directives:{Ripple:xe},props:Ne(),setup(e,i){let{attrs:n,slots:t}=i;const{themeClasses:f}=ne(e),{borderClasses:d}=Ae(e),{colorClasses:g,colorStyles:p,variantClasses:k}=Ie(e),{densityClasses:c}=Pe(e),{dimensionStyles:l}=Se(e),{elevationClasses:j}=se(e),{loaderClasses:E}=Be(e),{locationStyles:N}=Le(e),{positionClasses:M}=Te(e),{roundedClasses:O}=ie(e),o=De(e,n),$=A(()=>e.link!==!1&&o.isLink.value),u=A(()=>!e.disabled&&e.link!==!1&&(e.link||o.isClickable.value));return C(()=>{const z=$.value?"a":e.tag,H=!!(t.title||e.title),G=!!(t.subtitle||e.subtitle),J=H||G,K=!!(t.append||e.appendAvatar||e.appendIcon),Q=!!(t.prepend||e.prependAvatar||e.prependIcon),U=!!(t.image||e.image),W=J||Q||K,X=!!(t.text||e.text);return le(a(z,{class:["v-card",{"v-card--disabled":e.disabled,"v-card--flat":e.flat,"v-card--hover":e.hover&&!(e.disabled||e.flat),"v-card--link":u.value},f.value,d.value,g.value,c.value,j.value,E.value,M.value,O.value,k.value,e.class],style:[p.value,l.value,N.value,e.style],href:o.href.value,onClick:u.value&&o.navigate,tabindex:e.disabled?-1:void 0},{default:()=>{var h;return[U&&a("div",{key:"image",class:"v-card__image"},[t.image?a(y,{key:"image-defaults",disabled:!e.image,defaults:{VImg:{cover:!0,src:e.image}}},t.image):a(we,{key:"image-img",cover:!0,src:e.image},null)]),a(Re,{name:"v-card",active:!!e.loading,color:typeof e.loading=="boolean"?void 0:e.loading},{default:t.loader}),W&&a(Ee,{key:"item",prependAvatar:e.prependAvatar,prependIcon:e.prependIcon,title:e.title,subtitle:e.subtitle,appendAvatar:e.appendAvatar,appendIcon:e.appendIcon},{default:t.item,prepend:t.prepend,title:t.title,subtitle:t.subtitle,append:t.append}),X&&a(q,{key:"text"},{default:()=>{var x;return[((x=t.text)==null?void 0:x.call(t))??e.text]}}),(h=t.default)==null?void 0:h.call(t),t.actions&&a(w,null,{default:t.actions}),Fe(u.value,"v-card")]}}),[[de("ripple"),u.value&&e.ripple]])}),{}}}),Oe={},$e=I("div",{style:{display:"flex","justify-content":"center"}},[I("img",{src:""})],-1);function ze(e,i){return _(),T(me,{id:"inspire",class:"container"},{default:s(()=>[a(ve,null,{default:s(()=>[a(fe,null,{default:s(()=>[a(ge,null,{default:s(()=>[(_(),ce(oe,null,ue(24,n=>a(P,{key:n,cols:"4"},{default:s(()=>[a(P,null,{default:s(()=>[a(Me,{class:"mx-auto","max-width":"344",style:{"border-radius":"15px"}},{default:s(()=>[$e,a(F,null,{default:s(()=>[r("Nombre Product")]),_:1}),a(R,null,{default:s(()=>[r("Categoria")]),_:1}),a(w,null,{default:s(()=>[a(B,{color:"orange-lighten-2",variant:"text"},{default:s(()=>[r(" Comprar ")]),_:1}),a(B,{size:"small",color:"indigo-darken-4",style:{"background-color":"#8C9EFF",border:"1px solid #2137b1","border-radius":"15px"}},{default:s(()=>[r("Agregar al Carrito")]),_:1}),a(qe)]),_:1}),a(pe),a(q,null,{default:s(()=>[r(" Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam, dolorum minus nam eaque veniam voluptas dolor consequuntur quibusdam debitis nihil earum voluptatem soluta esse, architecto officiis temporibus natus rem dolore. ")]),_:1})]),_:1})]),_:1})]),_:2},1024)),64))]),_:1})]),_:1})]),_:1})]),_:1})}const He=re(Oe,[["render",ze]]),We={__name:"ProductosView",setup(e){return(i,n)=>(_(),T(He))}};export{We as default};