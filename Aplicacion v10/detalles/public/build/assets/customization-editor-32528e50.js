document.addEventListener("DOMContentLoaded",()=>{const E=document.getElementById("design-area"),y=document.getElementById("items-layer"),z=document.getElementById("text-layer"),C=document.getElementById("color-layer"),h=document.getElementById("card-layer"),M=document.getElementById("empty-state"),d=document.getElementById("base-product-image"),_=document.querySelectorAll(".add-extra-btn"),S=document.querySelectorAll(".color-swatch"),i=document.getElementById("input-frase"),s=document.getElementById("input-dedicatoria"),l=document.getElementById("input-destinatario"),k=document.getElementById("extras-count"),D=document.getElementById("summary-main-text"),T=document.getElementById("summary-color"),A=document.getElementById("selected-color-label"),N=document.getElementById("count-frase"),Z=document.getElementById("count-dedicatoria"),j=document.getElementById("count-destinatario"),q=document.getElementById("save-frase"),H=document.getElementById("save-dedicatoria"),R=document.getElementById("save-destinatario"),W=document.getElementById("save-color"),F=document.getElementById("save-design-json");let g="";const b=d?d.getAttribute("src"):"";let r=null,o=null;if(!E||!y||!z||!h)return;d&&b&&d.addEventListener("error",()=>{d.src=b});function w(){const e=y.querySelectorAll(".design-item").length>0,t=i&&i.value.trim()!==""||s&&s.value.trim()!==""||l&&l.value.trim()!=="";M&&(M.style.display=e||t?"none":"flex")}function B(){k&&(k.textContent=y.querySelectorAll(".design-item").length)}function G(){N&&i&&(N.textContent=`${i.value.length}/40`),Z&&s&&(Z.textContent=`${s.value.length}/100`),j&&l&&(j.textContent=`${l.value.length}/30`)}function K(){const e=[];return y.querySelectorAll(".design-item").forEach(t=>{const n=t.querySelector("img");e.push({id:t.dataset.extraId||"",name:t.dataset.extraName||"",image:n?n.getAttribute("src"):"",left:t.style.left||"0px",top:t.style.top||"0px",width:t.style.width||"140px",height:t.style.height||"140px"})}),{frase:i?i.value:"",dedicatoria:s?s.value:"",destinatario:l?l.value:"",color:g,base_image:d?d.getAttribute("src"):"",card:o?{left:o.style.left||"0px",top:o.style.top||"0px",width:o.style.width||"84px",height:o.style.height||"48px"}:null,items:e}}function f(){const e=i&&i.value.trim()||l&&l.value.trim()||"—";D&&(D.textContent=e),T&&(T.textContent=g||"Original"),A&&(A.textContent=g||"Original"),q&&i&&(q.value=i.value),H&&s&&(H.value=s.value),R&&l&&(R.value=l.value),W&&(W.value=g),F&&(F.value=JSON.stringify(K()))}function O(e,t,n,c,u=E){const a=Math.max(0,u.clientWidth-n),p=Math.max(0,u.clientHeight-c);return{left:Math.max(0,Math.min(e,a)),top:Math.max(0,Math.min(t,p))}}function P(e,t=E,n=null){let c=!1,u=0,a=0;const p=m=>{if(!c)return;const v=t.getBoundingClientRect(),Y=e.getBoundingClientRect(),ae=m.clientX-v.left-u,re=m.clientY-v.top-a,J=O(ae,re,Y.width,Y.height,t);e.style.left=`${J.left}px`,e.style.top=`${J.top}px`},x=()=>{c&&(c=!1,e.style.zIndex=e.dataset.baseZ||"10",e.classList.remove("cursor-grabbing"),e.classList.add("cursor-grab"),document.removeEventListener("mousemove",p),document.removeEventListener("mouseup",x),typeof n=="function"&&n(),f())};e.addEventListener("mousedown",m=>{if(m.target.closest(".remove-item"))return;m.preventDefault(),m.stopPropagation(),c=!0;const v=e.getBoundingClientRect();u=m.clientX-v.left,a=m.clientY-v.top,e.style.zIndex="60",e.classList.remove("cursor-grab"),e.classList.add("cursor-grabbing"),document.addEventListener("mousemove",p),document.addEventListener("mouseup",x)})}function L(e,t){let n=document.getElementById(e);return n||(n=document.createElement("div"),n.id=e,n.className=`absolute left-3 right-3 text-center pointer-events-none ${t}`,z.appendChild(n)),n}function Q(){const e=h.clientWidth,t=h.clientHeight;return{left:e*.22,top:t*.72,zoneWidth:e*.34,zoneHeight:t*.18}}function U(){const e=document.getElementById("card-zone");e&&e.remove(),r=document.createElement("div"),r.id="card-zone",r.className="absolute rounded-lg border border-dashed border-pink-300 bg-white/10",r.style.pointerEvents="auto",r.style.zIndex="30";const t=Q();r.style.left=`${t.left}px`,r.style.top=`${t.top}px`,r.style.width=`${t.zoneWidth}px`,r.style.height=`${t.zoneHeight}px`,h.appendChild(r)}function $(){const e=document.getElementById("card-dedicatoria-text");e&&(e.textContent=s?s.value.trim():"")}function V(){if(!o||!r)return;const e=o.getBoundingClientRect(),t=O(parseFloat(o.style.left||"0"),parseFloat(o.style.top||"0"),e.width,e.height,r);o.style.left=`${t.left}px`,o.style.top=`${t.top}px`}function ee(){if(!h||!r)return;const e=document.getElementById("preview-card-wrapper");e&&e.remove(),o=document.createElement("div"),o.id="preview-card-wrapper",o.className="absolute select-none cursor-grab",o.dataset.baseZ="35",o.style.width="84px",o.style.height="48px",o.style.zIndex="35",o.style.pointerEvents="auto";const t=Math.max(0,(r.clientWidth-84)/2),n=Math.max(0,(r.clientHeight-48)/2);o.style.left=`${t}px`,o.style.top=`${n}px`,o.innerHTML=`
            <div class="relative w-full h-full">
                <img
                    src="/storage/cards/tarjeta-base.png"
                    alt="Tarjeta base"
                    class="w-full h-full object-contain pointer-events-none select-none"
                    draggable="false"
                    style="
                        transform: rotate(-8deg);
                        transform-origin: center center;
                        filter: drop-shadow(0 3px 6px rgba(0,0,0,0.18));
                        opacity: 0.98;
                    "
                >
                <div
                    id="card-dedicatoria-text"
                    class="absolute inset-0 flex items-center justify-center text-center px-2 pointer-events-none"
                    style="
                        font-size: 5px;
                        line-height: 1.05;
                        color: #4B5563;
                        white-space: pre-wrap;
                        word-break: break-word;
                        overflow: hidden;
                        transform: rotate(-8deg);
                        transform-origin: center center;
                    "
                ></div>
            </div>
        `,r.appendChild(o),P(o,r,V),$()}function I(){const e=L("preview-frase","font-semibold text-xs text-pink-700"),t=L("preview-dedicatoria","text-[11px] md:text-xs text-gray-700 leading-snug"),n=L("preview-destinatario","font-semibold text-[10px] text-pink-700");e.style.bottom="10px",e.style.top="auto",e.textContent=i?i.value.trim():"",t.textContent="",t.style.top="auto",t.style.bottom="auto",n.textContent="",n.style.top="auto",n.style.bottom="auto",$(),w(),G(),f()}function te(e){const t=(e||"").toLowerCase();return t.includes("globo")?{width:160,height:160}:t.includes("peluche")?{width:150,height:150}:t.includes("chocolate")?{width:130,height:130}:t.includes("foto")?{width:140,height:140}:{width:140,height:140}}function ne(e){const t=e.dataset.extraImage||"",n=e.dataset.extraName||"Extra",c=e.dataset.extraId||"";if(!t)return;const u=te(n),a=document.createElement("div");a.className="design-item absolute select-none cursor-grab group",a.dataset.extraId=c,a.dataset.extraName=n,a.dataset.baseZ="20",a.style.left="20px",a.style.top="20px",a.style.width=`${u.width}px`,a.style.height=`${u.height}px`,a.style.zIndex="20",a.style.pointerEvents="auto",a.innerHTML=`
            <div class="relative w-full h-full">
                <img
                    src="${t}"
                    alt="${n}"
                    class="w-full h-full object-contain pointer-events-none select-none"
                    draggable="false"
                >
                <button
                    type="button"
                    class="remove-item absolute -top-2 -right-2 w-6 h-6 rounded-full bg-red-500 text-white text-xs hidden group-hover:flex items-center justify-center shadow pointer-events-auto"
                    aria-label="Eliminar"
                >
                    ×
                </button>
            </div>
        `,y.appendChild(a),P(a,E);const p=a.querySelector(".remove-item");p&&p.addEventListener("click",x=>{x.preventDefault(),x.stopPropagation(),a.remove(),B(),w(),f()}),B(),w(),f()}function oe(e,t=""){g=e||"",d&&(t&&t.trim()!==""?d.src=t:b&&(d.src=b)),C&&(C.style.backgroundColor="transparent",C.style.opacity="0"),S.forEach(n=>{n.classList.remove("ring-2","ring-pink-400","ring-offset-2"),(n.dataset.color||"").trim()===g&&n.classList.add("ring-2","ring-pink-400","ring-offset-2")}),f()}function X(){U(),ee(),$()}_.forEach(e=>{e.addEventListener("click",()=>{ne(e)})}),S.forEach(e=>{e.addEventListener("click",()=>{const t=e.dataset.color||"",n=e.dataset.image||"";oe(t,n)})}),i&&i.addEventListener("input",I),s&&s.addEventListener("input",I),l&&l.addEventListener("input",I),window.addEventListener("resize",()=>{X()}),X(),I(),B(),w(),f()});
