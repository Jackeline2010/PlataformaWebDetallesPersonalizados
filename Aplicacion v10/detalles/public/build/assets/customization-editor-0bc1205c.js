document.addEventListener("DOMContentLoaded",()=>{const s=document.getElementById("design-area"),b=document.getElementById("items-layer"),H=document.getElementById("text-layer"),C=document.getElementById("color-layer");document.getElementById("card-layer");const z=document.getElementById("photo-layer"),M=document.getElementById("empty-state"),p=document.getElementById("base-product-image"),v=document.getElementById("editor-wrapper"),h=document.getElementById("photo-guide-zone"),ne=document.querySelectorAll(".add-extra-btn"),R=document.querySelectorAll(".color-swatch"),l=document.getElementById("input-frase"),d=document.getElementById("input-dedicatoria"),u=document.getElementById("input-destinatario"),T=document.getElementById("extras-count"),U=document.getElementById("summary-main-text"),k=document.getElementById("summary-color"),W=document.getElementById("selected-color-label"),D=document.getElementById("count-frase"),P=document.getElementById("count-dedicatoria"),q=document.getElementById("count-destinatario"),A=document.getElementById("save-frase"),O=document.getElementById("save-dedicatoria"),Z=document.getElementById("save-destinatario"),N=document.getElementById("save-color"),F=document.getElementById("save-design-json"),V=document.getElementById("input-foto")||document.getElementById("input-photo")||document.querySelector('input[type="file"][name="foto"]')||document.querySelector('input[type="file"][name="foto_cliente"]')||document.querySelector('input[type="file"][name="photo"]')||document.querySelector('input[type="file"]'),oe=s&&s.dataset.cardTemplate||v&&v.dataset.cardTemplate||"/storage/cards/tarjeta-base.png",X=s&&s.dataset.frameVertical||v&&v.dataset.frameVertical||"",Y=s&&s.dataset.frameHorizontal||v&&v.dataset.frameHorizontal||"";let x="";const L=p?p.getAttribute("src"):"";let i=null,r=null,c={src:"",orientation:"vertical",objectUrl:null};if(!s||!b||!H)return;p&&L&&p.addEventListener("error",()=>{p.src=L});function E(){const e=b.querySelectorAll(".design-item").length>0,t=!!document.getElementById("preview-card-wrapper"),n=!!document.getElementById("photo-frame-wrapper"),o=l&&l.value.trim()!==""||d&&d.value.trim()!==""||u&&u.value.trim()!=="";M&&(M.style.display=e||o||t||n?"none":"flex")}function $(){T&&(T.textContent=b.querySelectorAll(".design-item").length)}function re(){D&&l&&(D.textContent=`${l.value.length}/40`),P&&d&&(P.textContent=`${d.value.length}/100`),q&&u&&(q.textContent=`${u.value.length}/30`)}function ae(){const e=[];return b.querySelectorAll(".design-item").forEach(t=>{const n=t.querySelector("img");e.push({id:t.dataset.extraId||"",name:t.dataset.extraName||"",image:n?n.getAttribute("src"):"",left:t.style.left||"0px",top:t.style.top||"0px",width:t.style.width||"140px",height:t.style.height||"140px"})}),{frase:l?l.value:"",dedicatoria:d?d.value:"",destinatario:u?u.value:"",color:x,base_image:p?p.getAttribute("src"):"",photo:c.src?{src:c.src,orientation:c.orientation}:null,card:r?{left:r.style.left||"0px",top:r.style.top||"0px",width:r.style.width||"84px",height:r.style.height||"48px"}:null,items:e}}function f(){const e=l&&l.value.trim()||u&&u.value.trim()||"—";U&&(U.textContent=e),k&&(k.textContent=x||"Original"),W&&(W.textContent=x||"Original"),A&&l&&(A.value=l.value),O&&d&&(O.value=d.value),Z&&u&&(Z.value=u.value),N&&(N.value=x),F&&(F.value=JSON.stringify(ae()))}function J(e,t,n,o,m=s){const a=Math.max(0,m.clientWidth-n),y=Math.max(0,m.clientHeight-o);return{left:Math.max(0,Math.min(e,a)),top:Math.max(0,Math.min(t,y))}}function _(e,t=s,n=null){let o=!1,m=0,a=0;const y=g=>{if(!o)return;const I=t.getBoundingClientRect(),ee=e.getBoundingClientRect(),ye=g.clientX-I.left-m,ve=g.clientY-I.top-a,te=J(ye,ve,ee.width,ee.height,t);e.style.left=`${te.left}px`,e.style.top=`${te.top}px`},w=()=>{o&&(o=!1,e.style.zIndex=e.dataset.baseZ||"10",e.classList.remove("cursor-grabbing"),e.classList.add("cursor-grab"),document.removeEventListener("mousemove",y),document.removeEventListener("mouseup",w),typeof n=="function"&&n(),f())};e.addEventListener("mousedown",g=>{if(g.target.closest(".remove-item"))return;g.preventDefault(),g.stopPropagation(),o=!0;const I=e.getBoundingClientRect();m=g.clientX-I.left,a=g.clientY-I.top,e.style.zIndex="60",e.classList.remove("cursor-grab"),e.classList.add("cursor-grabbing"),document.addEventListener("mousemove",y),document.addEventListener("mouseup",w)})}function j(e,t){let n=document.getElementById(e);return n||(n=document.createElement("div"),n.id=e,n.className=`absolute left-3 right-3 text-center pointer-events-none ${t}`,H.appendChild(n)),n}function ie(){const e=s.clientWidth,t=s.clientHeight;return{left:e*.22,top:t*.72,zoneWidth:e*.34,zoneHeight:t*.18}}function se(){const e=document.getElementById("card-zone");e&&e.remove(),i=document.createElement("div"),i.id="card-zone",i.className="absolute rounded-lg border border-dashed border-pink-300 bg-white/10",i.style.pointerEvents="auto",i.style.zIndex="30";const t=ie();i.style.left=`${t.left}px`,i.style.top=`${t.top}px`,i.style.width=`${t.zoneWidth}px`,i.style.height=`${t.zoneHeight}px`,s.appendChild(i)}function S(){const e=document.getElementById("card-dedicatoria-text");e&&(e.textContent=d?d.value.trim():"")}function le(){if(!r||!i)return;const e=r.getBoundingClientRect(),t=J(parseFloat(r.style.left||"0"),parseFloat(r.style.top||"0"),e.width,e.height,i);r.style.left=`${t.left}px`,r.style.top=`${t.top}px`}function ce(){if(!i)return;const e=document.getElementById("preview-card-wrapper");e&&e.remove(),r=document.createElement("div"),r.id="preview-card-wrapper",r.className="absolute select-none cursor-grab",r.dataset.baseZ="35",r.style.width="84px",r.style.height="48px",r.style.zIndex="35",r.style.pointerEvents="auto";const t=Math.max(0,(i.clientWidth-84)/2),n=Math.max(0,(i.clientHeight-48)/2);r.style.left=`${t}px`,r.style.top=`${n}px`,r.innerHTML=`
            <div class="relative w-full h-full">
                <img
                    src="${oe}"
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
        `,i.appendChild(r),_(r,i,le),S()}function de(){if(h)return{left:h.offsetLeft-h.offsetWidth*.03,top:h.offsetTop-h.offsetHeight*.03,zoneWidth:h.offsetWidth*1.1,zoneHeight:h.offsetHeight*1.1};const e=s.clientWidth,t=s.clientHeight;return{left:e*.64,top:t*.08,zoneWidth:e*.3,zoneHeight:t*.32}}function ue(){return c.orientation==="horizontal"?Y||X:X||Y}function G(){if(!z)return;const e=document.getElementById("photo-frame-wrapper");if(e&&e.remove(),!c.src){E(),f();return}const t=de(),n=ue(),o=document.createElement("div");o.id="photo-frame-wrapper",o.className="absolute",o.style.left=`${t.left}px`,o.style.top=`${t.top}px`,o.style.width=`${t.zoneWidth}px`,o.style.height=`${t.zoneHeight}px`,o.style.zIndex="25",o.style.pointerEvents="none";const m=(c.orientation==="horizontal","12% 10% 14% 10%");o.innerHTML=`
    <div class="relative w-full h-full">
        <div
            class="absolute overflow-hidden rounded-md"
            style="inset: ${m};"
        >
           <img

        src="${c.src}"
        alt="Foto del cliente"
        class="w-full h-full object-cover select-none pointer-events-none"
        draggable="false"
        style="transform: scale(1.02); transform-origin: center center;"
        >
        </div>
        ${n?`
            <img
                src="${n}"
                alt="Portarretrato"
                class="absolute inset-0 w-full h-full object-contain select-none pointer-events-none"
                draggable="false"
            >
        `:""}
    </div>
`,z.appendChild(o),E(),f()}function me(e){return new Promise(t=>{const n=URL.createObjectURL(e),o=new Image;o.onload=()=>{const m=o.width>=o.height?"horizontal":"vertical";URL.revokeObjectURL(n),t(m)},o.onerror=()=>{URL.revokeObjectURL(n),t("vertical")},o.src=n})}async function pe(e){if(!e||!z)return;c.objectUrl&&(URL.revokeObjectURL(c.objectUrl),c.objectUrl=null);const t=await me(e),n=URL.createObjectURL(e);c.src=n,c.objectUrl=n,c.orientation=t,G()}function B(){const e=j("preview-frase","font-semibold text-xs text-pink-700"),t=j("preview-dedicatoria","text-[11px] md:text-xs text-gray-700 leading-snug"),n=j("preview-destinatario","font-semibold text-[10px] text-pink-700");e.style.bottom="10px",e.style.top="auto",e.textContent=l?l.value.trim():"",t.textContent="",t.style.top="auto",t.style.bottom="auto",n.textContent="",n.style.top="auto",n.style.bottom="auto",S(),E(),re(),f()}function fe(e){const t=(e||"").toLowerCase();return t.includes("globo")?{width:160,height:160}:t.includes("peluche")?{width:150,height:150}:t.includes("chocolate")?{width:130,height:130}:t.includes("foto")?{width:140,height:140}:{width:140,height:140}}function ge(e){const t=e.dataset.extraImage||"",n=e.dataset.extraName||"Extra",o=e.dataset.extraId||"";if(!t)return;const m=fe(n),a=document.createElement("div");a.className="design-item absolute select-none cursor-grab group",a.dataset.extraId=o,a.dataset.extraName=n,a.dataset.baseZ="20",a.style.left="20px",a.style.top="20px",a.style.width=`${m.width}px`,a.style.height=`${m.height}px`,a.style.zIndex="20",a.style.pointerEvents="auto",a.innerHTML=`
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
        `,b.appendChild(a),_(a,s);const y=a.querySelector(".remove-item");y&&y.addEventListener("click",w=>{w.preventDefault(),w.stopPropagation(),a.remove(),$(),E(),f()}),$(),E(),f()}function he(e,t=""){x=e||"",p&&(t&&t.trim()!==""?p.src=t:L&&(p.src=L)),C&&(C.style.backgroundColor="transparent",C.style.opacity="0"),R.forEach(n=>{n.classList.remove("ring-2","ring-pink-400","ring-offset-2"),(n.dataset.color||"").trim()===x&&n.classList.add("ring-2","ring-pink-400","ring-offset-2")}),f()}function K(){se(),ce(),S()}function Q(){G()}ne.forEach(e=>{e.addEventListener("click",()=>{ge(e)})}),R.forEach(e=>{e.addEventListener("click",()=>{const t=e.dataset.color||"",n=e.dataset.image||"";he(t,n)})}),V&&V.addEventListener("change",async e=>{const t=e.target.files&&e.target.files[0]?e.target.files[0]:null;t&&await pe(t)}),l&&l.addEventListener("input",B),d&&d.addEventListener("input",B),u&&u.addEventListener("input",B),window.addEventListener("resize",()=>{K(),Q()}),K(),Q(),B(),$(),E(),f()});
