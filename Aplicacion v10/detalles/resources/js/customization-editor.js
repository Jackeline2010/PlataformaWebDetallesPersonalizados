document.addEventListener('DOMContentLoaded', () => {
    const designArea = document.getElementById('design-area');
    const itemsLayer = document.getElementById('items-layer');
    const textLayer = document.getElementById('text-layer');
    const colorLayer = document.getElementById('color-layer');
    const cardLayer = document.getElementById('card-layer');
    const photoLayer = document.getElementById('photo-layer');
    const emptyState = document.getElementById('empty-state');
    const baseProductImage = document.getElementById('base-product-image');
    const editorWrapper = document.getElementById('editor-wrapper');
    const photoGuideZone = document.getElementById('photo-guide-zone');

    const config = window.productConfig || {};
    const zones = config.zones || {};

    const addButtons = document.querySelectorAll('.add-extra-btn');
    const colorButtons = document.querySelectorAll('.color-swatch');

    const fraseInput = document.getElementById('input-frase');
    const dedicatoriaInput = document.getElementById('input-dedicatoria');
    const destinatarioInput = document.getElementById('input-destinatario');
    const restoreCardBtn = document.getElementById('restore-card-btn');

    const extrasCount = document.getElementById('extras-count');
    const summaryMainText = document.getElementById('summary-main-text');
    const summaryColor = document.getElementById('summary-color');
    const selectedColorLabel = document.getElementById('selected-color-label');

    const countFrase = document.getElementById('count-frase');
    const countDedicatoria = document.getElementById('count-dedicatoria');
    const countDestinatario = document.getElementById('count-destinatario');

    const saveFrase = document.getElementById('save-frase');
    const saveDedicatoria = document.getElementById('save-dedicatoria');
    const saveDestinatario = document.getElementById('save-destinatario');
    const saveColor = document.getElementById('save-color');
    const saveDesignJson = document.getElementById('save-design-json');

    const photoInput =
        document.getElementById('input-foto') ||
        document.querySelector('input[name="customer_photo"]') ||
        document.getElementById('input-photo') ||
        document.querySelector('input[type="file"][name="foto"]') ||
        document.querySelector('input[type="file"][name="foto_cliente"]') ||
        document.querySelector('input[type="file"][name="photo"]') ||
        document.querySelector('input[type="file"]');

    const photoAdjustModal = document.getElementById('photo-adjust-modal');
    const closePhotoAdjustModal = document.getElementById('close-photo-adjust-modal');
    const photoAdjustWindow = document.getElementById('photo-adjust-window');
    const photoAdjustImage = document.getElementById('photo-adjust-image');
    const photoAdjustFrame = document.getElementById('photo-adjust-frame');
    const photoZoomRange = document.getElementById('photo-zoom-range');
    const savePhotoAdjust = document.getElementById('save-photo-adjust');

    const cardTemplate =
        config.cardImage ||
        (designArea && designArea.dataset.cardTemplate) ||
        (editorWrapper && editorWrapper.dataset.cardTemplate) ||
        '/storage/cards/tarjeta-base.png';

    const frameVertical =
        config.frameImage ||
        (designArea && designArea.dataset.frameVertical) ||
        (editorWrapper && editorWrapper.dataset.frameVertical) ||
        '/storage/frames/portarretrato-vertical.png';

    const frameHorizontal =
        (designArea && designArea.dataset.frameHorizontal) ||
        (editorWrapper && editorWrapper.dataset.frameHorizontal) ||
        frameVertical;

    let selectedColor = '';
    const originalBaseImage = baseProductImage ? baseProductImage.getAttribute('src') : '';

    let cardZone = null;
    let cardWrapper = null;
    let cardEnabled = true;
    let extrasZoneEl = null;
    let photoMoveZoneEl = null;

    let photoState = {
        src: '',
        orientation: 'vertical',
        objectUrl: null,
        offsetX: 0,
        offsetY: 0,
        scale: 1.12,
        frameLeft: null,
        frameTop: null,
    };

    if (!designArea || !itemsLayer || !textLayer) {
        return;
    }

    if (baseProductImage && originalBaseImage) {
        baseProductImage.addEventListener('error', () => {
            baseProductImage.src = originalBaseImage;
        });
    }

    function zoneToPx(zone) {
        const width = designArea.clientWidth;
        const height = designArea.clientHeight;

        if (!zone) return null;

        return {
            left: (Number(zone.x || 0) / 100) * width,
            top: (Number(zone.y || 0) / 100) * height,
            width: (Number(zone.width || 0) / 100) * width,
            height: (Number(zone.height || 0) / 100) * height,
        };
    }

    function expandMetrics(metrics, percent = 0.08) {
        if (!metrics) return null;

        const dx = designArea.clientWidth * percent;
        const dy = designArea.clientHeight * percent;

        const left = Math.max(0, metrics.left - dx);
        const top = Math.max(0, metrics.top - dy);
        const right = Math.min(designArea.clientWidth, metrics.left + metrics.width + dx);
        const bottom = Math.min(designArea.clientHeight, metrics.top + metrics.height + dy);

        return {
            left,
            top,
            width: Math.max(metrics.width, right - left),
            height: Math.max(metrics.height, bottom - top),
        };
    }

    function countWords(text) {
        return ((text || '').match(/\S+/g) || []).length;
    }

    function trimToMaxWords(text, maxWords) {
        const words = (text || '').match(/\S+/g) || [];
        if (words.length <= maxWords) return text;
        return words.slice(0, maxWords).join(' ');
    }

    function enforceDedicatoriaLimit() {
        if (!dedicatoriaInput) return '';

        const maxWords = parseInt(dedicatoriaInput.dataset.maxWords || '20', 10);
        const currentValue = dedicatoriaInput.value || '';
        const words = currentValue.match(/\S+/g) || [];

        if (words.length > maxWords) {
            dedicatoriaInput.value = trimToMaxWords(currentValue, maxWords);
        }

        return dedicatoriaInput.value || '';
    }

    function updateEmptyState() {
        const hasItems = itemsLayer.querySelectorAll('.design-item').length > 0;
        const hasCard = !!document.getElementById('preview-card-wrapper');
        const hasPhoto = !!document.getElementById('photo-frame-wrapper');
        const hasText =
            (fraseInput && fraseInput.value.trim() !== '') ||
            (dedicatoriaInput && dedicatoriaInput.value.trim() !== '') ||
            (destinatarioInput && destinatarioInput.value.trim() !== '');

        if (emptyState) {
            emptyState.style.display = hasItems || hasText || hasCard || hasPhoto ? 'none' : 'flex';
        }
    }

    function updateExtrasCount() {
        if (extrasCount) {
            extrasCount.textContent = itemsLayer.querySelectorAll('.design-item').length;
        }
    }

    function updateCounters() {
        if (countFrase && fraseInput) {
            countFrase.textContent = `${fraseInput.value.length}/40`;
        }

        if (countDedicatoria && dedicatoriaInput) {
            const maxWords = parseInt(dedicatoriaInput.dataset.maxWords || '20', 10);
            const totalWords = countWords(dedicatoriaInput.value);
            countDedicatoria.textContent = `${Math.min(totalWords, maxWords)}/${maxWords} palabras`;
        }

        if (countDestinatario && destinatarioInput) {
            countDestinatario.textContent = `${destinatarioInput.value.length}/30`;
        }
    }

    function exportDesignState() {
        const items = [];

        itemsLayer.querySelectorAll('.design-item').forEach((item) => {
            const img = item.querySelector('img');

            items.push({
                id: item.dataset.extraId || '',
                name: item.dataset.extraName || '',
                image: img ? img.getAttribute('src') : '',
                left: item.style.left || '0px',
                top: item.style.top || '0px',
                width: item.style.width || '140px',
                height: item.style.height || '140px',
            });
        });

        return {
            frase: fraseInput ? fraseInput.value : '',
            dedicatoria: dedicatoriaInput ? dedicatoriaInput.value : '',
            destinatario: destinatarioInput ? destinatarioInput.value : '',
            color: selectedColor,
            base_image: baseProductImage ? baseProductImage.getAttribute('src') : '',
            photo: photoState.src
                ? {
                    src: photoState.src,
                    orientation: photoState.orientation,
                    offsetX: photoState.offsetX,
                    offsetY: photoState.offsetY,
                    scale: photoState.scale,
                    frameLeft: photoState.frameLeft,
                    frameTop: photoState.frameTop,
                }
                : null,
            card: cardWrapper
                ? {
                    left: cardWrapper.style.left || '0px',
                    top: cardWrapper.style.top || '0px',
                    width: cardWrapper.style.width || '84px',
                    height: cardWrapper.style.height || '48px',
                }
                : null,
            zones,
            items,
        };
    }

    function updateSummary() {
        const mainText =
            (fraseInput && fraseInput.value.trim()) ||
            (destinatarioInput && destinatarioInput.value.trim()) ||
            '—';

        if (summaryMainText) {
            summaryMainText.textContent = mainText;
        }

        if (summaryColor) {
            summaryColor.textContent = selectedColor || 'Original';
        }

        if (selectedColorLabel) {
            selectedColorLabel.textContent = selectedColor || 'Original';
        }

        if (saveFrase && fraseInput) {
            saveFrase.value = fraseInput.value;
        }

        if (saveDedicatoria && dedicatoriaInput) {
            saveDedicatoria.value = dedicatoriaInput.value;
        }

        if (saveDestinatario && destinatarioInput) {
            saveDestinatario.value = destinatarioInput.value;
        }

        if (saveColor) {
            saveColor.value = selectedColor;
        }

        if (saveDesignJson) {
            saveDesignJson.value = JSON.stringify(exportDesignState());
        }
    }

    function isOverlapping(el1, el2) {
        if (!el1 || !el2) return false;

        const r1 = el1.getBoundingClientRect();
        const r2 = el2.getBoundingClientRect();

        return !(
            r1.right < r2.left ||
            r1.left > r2.right ||
            r1.bottom < r2.top ||
            r1.top > r2.bottom
        );
    }

    function getReservedElementsForExtras() {
        return [
            document.getElementById('photo-frame-wrapper'),
            document.getElementById('card-zone'),
            document.getElementById('preview-card-wrapper'),
        ].filter(Boolean);
    }

    function overlapsReservedZones(element) {
        return getReservedElementsForExtras().some((reserved) => isOverlapping(element, reserved));
    }

    function clampToMetrics(left, top, elWidth, elHeight, metrics) {
        const maxLeft = Math.max(metrics.left, metrics.left + metrics.width - elWidth);
        const maxTop = Math.max(metrics.top, metrics.top + metrics.height - elHeight);

        return {
            left: Math.max(metrics.left, Math.min(left, maxLeft)),
            top: Math.max(metrics.top, Math.min(top, maxTop)),
        };
    }

    function makeDraggableInMetrics(el, getMetrics, onMoveEnd = null) {
        let isDragging = false;
        let offsetX = 0;
        let offsetY = 0;

        const onMouseMove = (e) => {
            if (!isDragging) return;

            const metrics = typeof getMetrics === 'function' ? getMetrics() : getMetrics;
            if (!metrics) return;

            const parentRect = designArea.getBoundingClientRect();
            const elRect = el.getBoundingClientRect();

            const rawLeft = e.clientX - parentRect.left - offsetX;
            const rawTop = e.clientY - parentRect.top - offsetY;

            const clamped = clampToMetrics(rawLeft, rawTop, elRect.width, elRect.height, metrics);

            el.style.left = `${clamped.left}px`;
            el.style.top = `${clamped.top}px`;
        };

        const onMouseUp = () => {
            if (!isDragging) return;

            isDragging = false;
            el.style.zIndex = el.dataset.baseZ || '10';
            el.classList.remove('cursor-grabbing');
            el.classList.add('cursor-grab');

            document.removeEventListener('mousemove', onMouseMove);
            document.removeEventListener('mouseup', onMouseUp);

            if (typeof onMoveEnd === 'function') {
                onMoveEnd(el);
            }

            updateSummary();
        };

        el.addEventListener('mousedown', (e) => {
            if (e.target.closest('.remove-item')) return;

            e.preventDefault();
            e.stopPropagation();

            isDragging = true;

            const rect = el.getBoundingClientRect();
            offsetX = e.clientX - rect.left;
            offsetY = e.clientY - rect.top;

            el.style.zIndex = '80';
            el.classList.remove('cursor-grab');
            el.classList.add('cursor-grabbing');

            document.addEventListener('mousemove', onMouseMove);
            document.addEventListener('mouseup', onMouseUp);
        });
    }

    function createTextElement(id, className) {
        let el = document.getElementById(id);

        if (!el) {
            el = document.createElement('div');
            el.id = id;
            el.className = `absolute left-3 right-3 text-center pointer-events-none ${className}`;
            textLayer.appendChild(el);
        }

        return el;
    }

    function getCardZoneMetrics() {
        const configured = zoneToPx(zones.card_zone);

        if (configured) {
            return configured;
        }

        const width = designArea.clientWidth;
        const height = designArea.clientHeight;

        return {
            left: width * 0.22,
            top: height * 0.72,
            width: width * 0.34,
            height: height * 0.18,
        };
    }

    function renderCardZone() {
        const oldZone = document.getElementById('card-zone');
        if (oldZone) oldZone.remove();

        cardZone = document.createElement('div');
        cardZone.id = 'card-zone';
        cardZone.className = 'absolute rounded-lg border border-dashed border-pink-300 bg-white/10';
        cardZone.style.pointerEvents = 'auto';
        cardZone.style.zIndex = '30';

        const metrics = getCardZoneMetrics();

        cardZone.style.left = `${metrics.left}px`;
        cardZone.style.top = `${metrics.top}px`;
        cardZone.style.width = `${metrics.width}px`;
        cardZone.style.height = `${metrics.height}px`;

        designArea.appendChild(cardZone);
    }

    function getExtrasZoneMetrics() {
        const configured = zoneToPx(zones.extras_zone);

        if (configured) {
            return configured;
        }

        const width = designArea.clientWidth;
        const height = designArea.clientHeight;

        return {
            left: width * 0.08,
            top: height * 0.10,
            width: width * 0.84,
            height: height * 0.45,
        };
    }

    function renderExtrasZone() {
        const oldZone = document.getElementById('extras-zone');
        if (oldZone) oldZone.remove();

        const metrics = getExtrasZoneMetrics();

        extrasZoneEl = document.createElement('div');
        extrasZoneEl.id = 'extras-zone';
        extrasZoneEl.className = 'absolute rounded-xl border border-dashed border-purple-200 bg-purple-50/10';
        extrasZoneEl.style.left = `${metrics.left}px`;
        extrasZoneEl.style.top = `${metrics.top}px`;
        extrasZoneEl.style.width = `${metrics.width}px`;
        extrasZoneEl.style.height = `${metrics.height}px`;
        extrasZoneEl.style.zIndex = '5';
        extrasZoneEl.style.pointerEvents = 'none';

        designArea.appendChild(extrasZoneEl);
    }

    function updateCardText() {
        const textEl = document.getElementById('card-dedicatoria-text');
        if (!textEl) return;

        const safeText = enforceDedicatoriaLimit();
        textEl.textContent = safeText;

        const totalWords = countWords(safeText);

        let fontSize = 5.2;
        let lineHeight = 1.05;

        if (totalWords >= 6 && totalWords <= 10) {
            fontSize = 4.8;
        } else if (totalWords >= 11 && totalWords <= 15) {
            fontSize = 4.2;
        } else if (totalWords >= 16 && totalWords <= 20) {
            fontSize = 3.6;
            lineHeight = 1.0;
        }

        textEl.style.fontSize = `${fontSize}px`;
        textEl.style.lineHeight = String(lineHeight);
        textEl.style.whiteSpace = 'pre-wrap';
        textEl.style.wordBreak = 'break-word';
        textEl.style.overflowWrap = 'break-word';
        textEl.style.overflow = 'hidden';
        textEl.style.display = '-webkit-box';
        textEl.style.webkitLineClamp = '4';
        textEl.style.webkitBoxOrient = 'vertical';
    }

    function makeCardDraggableInsideZone(el, zoneEl) {
    let isDragging = false;
    let offsetX = 0;
    let offsetY = 0;

    const onMouseMove = (e) => {
        if (!isDragging) return;

        const zoneRect = zoneEl.getBoundingClientRect();
        const elRect = el.getBoundingClientRect();

        let left = e.clientX - zoneRect.left - offsetX;
        let top = e.clientY - zoneRect.top - offsetY;

        const maxLeft = Math.max(0, zoneEl.clientWidth - elRect.width);
        const maxTop = Math.max(0, zoneEl.clientHeight - elRect.height);

        left = Math.max(0, Math.min(left, maxLeft));
        top = Math.max(0, Math.min(top, maxTop));

        el.style.left = `${left}px`;
        el.style.top = `${top}px`;
    };

    const onMouseUp = () => {
        if (!isDragging) return;

        isDragging = false;
        el.style.zIndex = el.dataset.baseZ || '35';
        el.classList.remove('cursor-grabbing');
        el.classList.add('cursor-grab');

        document.removeEventListener('mousemove', onMouseMove);
        document.removeEventListener('mouseup', onMouseUp);

        updateSummary();
    };

    el.addEventListener('mousedown', (e) => {
        if (e.target.closest('.remove-card')) return;

        e.preventDefault();
        e.stopPropagation();

        isDragging = true;

        const rect = el.getBoundingClientRect();
        offsetX = e.clientX - rect.left;
        offsetY = e.clientY - rect.top;

        el.style.zIndex = '80';
        el.classList.remove('cursor-grab');
        el.classList.add('cursor-grabbing');

        document.addEventListener('mousemove', onMouseMove);
        document.addEventListener('mouseup', onMouseUp);
    });
}

    function renderCardTemplate() {
        if (!cardZone || !cardEnabled) return;

        const oldCard = document.getElementById('preview-card-wrapper');
        if (oldCard) oldCard.remove();

        cardWrapper = document.createElement('div');
        cardWrapper.id = 'preview-card-wrapper';
        cardWrapper.className = 'absolute select-none cursor-grab';
        cardWrapper.dataset.baseZ = '35';
        cardWrapper.style.width = '84px';
        cardWrapper.style.height = '48px';
        cardWrapper.style.zIndex = '35';
        cardWrapper.style.pointerEvents = 'auto';

        const initialLeft = Math.max(0, (cardZone.clientWidth - 84) / 2);
        const initialTop = Math.max(0, (cardZone.clientHeight - 48) / 2);

        cardWrapper.style.left = `${initialLeft}px`;
        cardWrapper.style.top = `${initialTop}px`;

        cardWrapper.innerHTML = `
            <div class="relative w-full h-full">
                <img
                    src="${cardTemplate}"
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
                    class="absolute pointer-events-none text-center"
                    style="
                        left: 16%;
                        top: 22%;
                        width: 68%;
                        height: 36%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        padding: 2px 4px;
                        font-size: 5px;
                        line-height: 1.05;
                        color: #4B5563;
                        white-space: pre-wrap;
                        word-break: break-word;
                        overflow-wrap: break-word;
                        overflow: hidden;
                        text-align: center;
                        transform: rotate(-8deg);
                        transform-origin: center center;
                    "
                ></div>
            </div>

            <button
    type="button"
    class="remove-card absolute -top-2 -right-2 w-6 h-6 rounded-full bg-red-500 text-white text-xs flex items-center justify-center shadow pointer-events-auto"
    aria-label="Quitar dedicatoria"
>
    ×
</button>
        `;

        cardZone.appendChild(cardWrapper);
        makeCardDraggableInsideZone(cardWrapper, cardZone);
        updateCardText();
        const removeCardBtn = cardWrapper.querySelector('.remove-card');

if (removeCardBtn) {
    removeCardBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();

        cardEnabled = false;

        if (dedicatoriaInput) {
            dedicatoriaInput.value = '';
        }

        if (saveDedicatoria) {
            saveDedicatoria.value = '';
        }

        cardWrapper.remove();
        cardWrapper = null;

        if (restoreCardBtn) {
            restoreCardBtn.classList.remove('hidden');
        }

        updateCounters();
        updateEmptyState();
        updateSummary();
    });
}
    }

    function getPhotoFrameMetrics() {
        const configured = zoneToPx(zones.photo_zone);

       if (configured) {
    return {
        left: configured.left + (configured.width * 0.04),
        top: configured.top + (configured.height * 0.04),
        width: configured.width * 1.15,
        height: configured.height * 1.15,
    };
}

        if (photoGuideZone) {
            return {
                left: photoGuideZone.offsetLeft - (photoGuideZone.offsetWidth * 0.06),
                top: photoGuideZone.offsetTop - (photoGuideZone.offsetHeight * 0.10),
                width: photoGuideZone.offsetWidth * 1.55,
                height: photoGuideZone.offsetHeight * 1.70,
            };
        }

        const width = designArea.clientWidth;
        const height = designArea.clientHeight;

        return {
            left: width * 0.60,
            top: height * 0.03,
            width: width * 0.18,
            height: height * 0.36,
        };
    }

    function getPhotoMoveMetrics() {
        return expandMetrics(getPhotoFrameMetrics(), 0.08);
    }

    function renderPhotoMoveZone() {
        const old = document.getElementById('photo-move-zone');
        if (old) old.remove();

        const metrics = getPhotoMoveMetrics();
        if (!metrics) return;

        photoMoveZoneEl = document.createElement('div');
        photoMoveZoneEl.id = 'photo-move-zone';
        photoMoveZoneEl.className = 'absolute rounded-xl border border-dashed border-blue-200 bg-blue-50/10';
        photoMoveZoneEl.style.left = `${metrics.left}px`;
        photoMoveZoneEl.style.top = `${metrics.top}px`;
        photoMoveZoneEl.style.width = `${metrics.width}px`;
        photoMoveZoneEl.style.height = `${metrics.height}px`;
        photoMoveZoneEl.style.zIndex = '6';
        photoMoveZoneEl.style.pointerEvents = 'none';

        designArea.appendChild(photoMoveZoneEl);
    }

    function getFrameSrc() {
        return photoState.orientation === 'horizontal'
            ? (frameHorizontal || frameVertical)
            : (frameVertical || frameHorizontal);
    }

    function getPhotoInset() {
    if (photoState.orientation === 'horizontal') {
        return {
            top: '10%',
            right: '22%',
            bottom: '30%',
            left: '22%',
            radius: '10px',
        };
    }

   return {
    top: '6%',
    right: '22%',
    bottom: '20%',
    left: '22%',
    radius: '10px',
    };
}

    function getAdjustWindowByOrientation() {
    const inset = getPhotoInset();

    return {
        left: inset.left,
        top: inset.top,
        width: `calc(100% - ${inset.left} - ${inset.right})`,
        height: `calc(100% - ${inset.top} - ${inset.bottom})`,
        radius: inset.radius,
    };
}

    function updateAdjustImageTransform() {
        if (!photoAdjustImage) return;

        photoAdjustImage.style.transform =
            `translate(calc(-50% + ${photoState.offsetX}px), calc(-50% + ${photoState.offsetY}px)) scale(${photoState.scale})`;
    }

    function clampPhotoOffsets(container) {
        if (!container) return;

        const rect = container.getBoundingClientRect();

        const scaledWidth = rect.width * photoState.scale;
        const scaledHeight = rect.height * photoState.scale;

        const overflowX = Math.max(0, (scaledWidth - rect.width) / 2);
        const overflowY = Math.max(0, (scaledHeight - rect.height) / 2);

        photoState.offsetX = Math.max(-overflowX, Math.min(photoState.offsetX, overflowX));
        photoState.offsetY = Math.max(-overflowY, Math.min(photoState.offsetY, overflowY));
    }

    function syncAdjustStage() {
    if (!photoAdjustWindow || !photoZoomRange) return;

    const frameWindow = getAdjustWindowByOrientation();

    photoAdjustWindow.style.position = 'absolute';
    photoAdjustWindow.style.left = frameWindow.left;
    photoAdjustWindow.style.top = frameWindow.top;
    photoAdjustWindow.style.width = frameWindow.width;
    photoAdjustWindow.style.height = frameWindow.height;
    photoAdjustWindow.style.borderRadius = frameWindow.radius;
    photoAdjustWindow.style.overflow = 'hidden';
    photoAdjustWindow.style.background = 'transparent';
    photoAdjustWindow.style.zIndex = '5';

    photoZoomRange.value = String(photoState.scale);

    requestAnimationFrame(() => {
        clampPhotoOffsets(photoAdjustWindow);
        updateAdjustImageTransform();
    });
}

   function openPhotoAdjustModal() {
    if (!photoAdjustModal || !photoAdjustImage) return false;

    photoAdjustImage.src = photoState.src || '';
    photoAdjustImage.style.position = 'absolute';
    photoAdjustImage.style.left = '50%';
    photoAdjustImage.style.top = '50%';
    photoAdjustImage.style.width = '100%';
    photoAdjustImage.style.height = '100%';
    photoAdjustImage.style.maxWidth = 'none';
    photoAdjustImage.style.maxHeight = 'none';
    photoAdjustImage.style.objectFit = 'cover';
    photoAdjustImage.style.transformOrigin = 'center center';
    photoAdjustImage.style.cursor = 'grab';
    photoAdjustImage.style.userSelect = 'none';
    photoAdjustImage.style.webkitUserDrag = 'none';

    if (photoAdjustFrame) {
        photoAdjustFrame.src = getFrameSrc() || photoAdjustFrame.src;
        photoAdjustFrame.style.pointerEvents = 'none';
    }

    photoAdjustModal.classList.remove('hidden');
    photoAdjustModal.classList.add('flex');

    requestAnimationFrame(() => {
        syncAdjustStage();
    });

    return true;
}
    function closeAdjustModal() {
        if (!photoAdjustModal) return;

        photoAdjustModal.classList.add('hidden');
        photoAdjustModal.classList.remove('flex');
    }

    function makePhotoDraggable(container, img) {
        let isDragging = false;
        let startX = 0;
        let startY = 0;

        container.addEventListener('mousedown', (e) => {
            e.preventDefault();
            e.stopPropagation();

            isDragging = true;
            startX = e.clientX;
            startY = e.clientY;
            img.style.cursor = 'grabbing';
        });

        document.addEventListener('mousemove', (e) => {
            if (!isDragging) return;

            const dx = e.clientX - startX;
            const dy = e.clientY - startY;

            startX = e.clientX;
            startY = e.clientY;

            photoState.offsetX += dx;
            photoState.offsetY += dy;

            clampPhotoOffsets(container);
            updateAdjustImageTransform();
        });

        document.addEventListener('mouseup', () => {
            if (!isDragging) return;
            isDragging = false;
            img.style.cursor = 'grab';
        });

        container.addEventListener('mouseleave', () => {
            if (!isDragging) return;
            isDragging = false;
            img.style.cursor = 'grab';
        });
    }

    function renderPhotoFrame() {
        if (!photoLayer) return;

        const oldPhoto = document.getElementById('photo-frame-wrapper');
        if (oldPhoto) oldPhoto.remove();

        renderPhotoMoveZone();

        if (!photoState.src) {
            updateEmptyState();
            updateSummary();
            return;
        }

        const metrics = getPhotoFrameMetrics();
        const moveMetrics = getPhotoMoveMetrics();
        const frameSrc = getFrameSrc();
        const inset = getPhotoInset();

        const wrapper = document.createElement('div');
        wrapper.id = 'photo-frame-wrapper';
        wrapper.className = 'absolute select-none cursor-grab';
        wrapper.dataset.baseZ = '28';

        const initialLeft = photoState.frameLeft ?? metrics.left;
        const initialTop = photoState.frameTop ?? metrics.top;
        const clampedInitial = clampToMetrics(initialLeft, initialTop, metrics.width, metrics.height, moveMetrics);

        wrapper.style.left = `${clampedInitial.left}px`;
        wrapper.style.top = `${clampedInitial.top}px`;
        wrapper.style.width = `${metrics.width}px`;
        wrapper.style.height = `${metrics.height}px`;
        wrapper.style.zIndex = '28';
        wrapper.style.pointerEvents = 'auto';

        wrapper.innerHTML = `
            <div class="relative w-full h-full">
                <div
                    class="absolute overflow-hidden"
                    style="
                        top: ${inset.top};
                        right: ${inset.right};
                        bottom: ${inset.bottom};
                        left: ${inset.left};
                        border-radius: ${inset.radius};
                    "
                >
                    <img
                        src="${photoState.src}"
                        alt="Foto del cliente"
                        class="select-none pointer-events-none"
                        draggable="false"
                        style="
                            position: absolute;
                            left: 50%;
                            top: 50%;
                            width: 100%;
                            height: 100%;
                            max-width: none;
                            max-height: none;
                            object-fit: cover;
                            transform: translate(calc(-50% + ${photoState.offsetX}px), calc(-50% + ${photoState.offsetY}px)) scale(${photoState.scale});
                            transform-origin: center center;
                        "
                    >
                </div>
                ${frameSrc ? `
                    <img
                        src="${frameSrc}"
                        alt="Portarretrato"
                        class="absolute inset-0 w-full h-full object-contain select-none pointer-events-none"
                        draggable="false"
                    >
                ` : ''}
            </div>
        `;

        photoLayer.appendChild(wrapper);

        makeDraggableInMetrics(wrapper, getPhotoMoveMetrics, (el) => {
            photoState.frameLeft = parseFloat(el.style.left || '0');
            photoState.frameTop = parseFloat(el.style.top || '0');

            itemsLayer.querySelectorAll('.design-item').forEach((item) => {
                if (overlapsReservedZones(item)) {
                    item.style.left = item.dataset.lastValidLeft || item.style.left;
                    item.style.top = item.dataset.lastValidTop || item.style.top;
                }
            });

            updateSummary();
        });

        updateEmptyState();
        updateSummary();
    }

    function detectImageInfo(file) {
    return new Promise((resolve) => {
        const tempUrl = URL.createObjectURL(file);
        const img = new Image();

        img.onload = () => {
            const orientation = img.width >= img.height ? 'horizontal' : 'vertical';

            resolve({
                orientation,
                width: img.width,
                height: img.height,
            });

            URL.revokeObjectURL(tempUrl);
        };

        img.onerror = () => {
            URL.revokeObjectURL(tempUrl);

            resolve({
                orientation: 'vertical',
                width: 1,
                height: 1,
            });
        };

        img.src = tempUrl;
    });
}

        function handlePhotoChange(file) {
    return new Promise(async (resolve) => {

        const imageInfo = await detectImageInfo(file);
        const objectUrl = URL.createObjectURL(file);

        photoState.src = objectUrl;
        photoState.objectUrl = objectUrl;
        photoState.orientation = imageInfo.orientation;

        photoState.offsetX = 0;
        photoState.offsetY = 0;

        // 🔥 AUTO-FIT REAL
        photoState.scale = 4;

        const modalOpened = openPhotoAdjustModal();

        if (modalOpened) {
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {

                    const autoScale = calculatePhotoAutoFitScale(
                        imageInfo.width,
                        imageInfo.height
                    );

                    photoState.scale = Math.max(autoScale, 3);

                    if (photoZoomRange) {
                        photoZoomRange.value = String(photoState.scale);
                    }

                    clampPhotoOffsets(photoAdjustWindow);
                    updateAdjustImageTransform();
                });
            });
        } else {
            renderPhotoFrame();
        }

        resolve();
    });
}

       function calculatePhotoAutoFitScale(imageWidth, imageHeight) {
    if (!photoAdjustWindow) return 3;

    const containerRect = photoAdjustWindow.getBoundingClientRect();

    if (!containerRect.width || !containerRect.height) {
        return 3;
    }

    const imageRatio = imageWidth / imageHeight;
    const containerRatio = containerRect.width / containerRect.height;

    let scale;

    if (imageRatio > containerRatio) {
        scale = (containerRect.height / containerRect.width) * imageRatio;
    } else {
        scale = (containerRect.width / containerRect.height) / imageRatio;
    }

    // 🔥 MÁS AGRESIVO para llenar el marco
    return Math.max(3, Math.min(scale * 2.2, 6));
}


    function renderTexts() {
        const fraseEl = createTextElement(
            'preview-frase',
            'font-semibold text-xs text-pink-700'
        );

        const dedicatoriaEl = createTextElement(
            'preview-dedicatoria',
            'text-[11px] md:text-xs text-gray-700 leading-snug'
        );

        const destinatarioEl = createTextElement(
            'preview-destinatario',
            'font-semibold text-[10px] text-pink-700'
        );

        fraseEl.style.bottom = '10px';
        fraseEl.style.top = 'auto';
        fraseEl.textContent = fraseInput ? fraseInput.value.trim() : '';

        dedicatoriaEl.textContent = '';
        dedicatoriaEl.style.top = 'auto';
        dedicatoriaEl.style.bottom = 'auto';

        destinatarioEl.textContent = '';
        destinatarioEl.style.top = 'auto';
        destinatarioEl.style.bottom = 'auto';

        updateCardText();
        updateEmptyState();
        updateCounters();
        updateSummary();
    }

    function getDefaultSize(name) {
        const value = (name || '').toLowerCase();

        if (value.includes('globo')) {
            return { width: 115, height: 115 };
        }

        if (value.includes('peluche')) {
            return { width: 120, height: 120 };
        }

        if (value.includes('chocolate')) {
            return { width: 105, height: 105 };
        }

        if (value.includes('foto')) {
            return { width: 110, height: 110 };
        }

        return { width: 110, height: 110 };
    }

    function getInitialExtraPosition(width, height) {
        const metrics = getExtrasZoneMetrics();

        const left = metrics.left + Math.max(0, (metrics.width - width) / 2);
        const top = metrics.top + Math.max(0, (metrics.height - height) / 2);

        return clampToMetrics(left, top, width, height, metrics);
    }

    function addExtra(btn) {
        const image = btn.dataset.extraImage || '';
        const name = btn.dataset.extraName || 'Extra';
        const extraId = btn.dataset.extraId || '';

        if (!image) return;

        const existing = itemsLayer.querySelector(`.design-item[data-extra-id="${extraId}"]`);
        if (existing) return;

        const size = getDefaultSize(name);
        const initial = getInitialExtraPosition(size.width, size.height);

        const wrapper = document.createElement('div');
        wrapper.className = 'design-item absolute select-none cursor-grab group';
        wrapper.dataset.extraId = extraId;
        wrapper.dataset.extraName = name;
        wrapper.dataset.baseZ = '20';
        wrapper.dataset.lastValidLeft = `${initial.left}px`;
        wrapper.dataset.lastValidTop = `${initial.top}px`;
        wrapper.style.left = `${initial.left}px`;
        wrapper.style.top = `${initial.top}px`;
        wrapper.style.width = `${size.width}px`;
        wrapper.style.height = `${size.height}px`;
        wrapper.style.zIndex = '20';
        wrapper.style.pointerEvents = 'auto';

        wrapper.innerHTML = `
            <div class="relative w-full h-full">
                <img
                    src="${image}"
                    alt="${name}"
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
        `;

        itemsLayer.appendChild(wrapper);

        if (overlapsReservedZones(wrapper)) {
            const metrics = getExtrasZoneMetrics();
            wrapper.style.left = `${metrics.left}px`;
            wrapper.style.top = `${metrics.top}px`;
            wrapper.dataset.lastValidLeft = wrapper.style.left;
            wrapper.dataset.lastValidTop = wrapper.style.top;
        }

        makeDraggableInMetrics(wrapper, getExtrasZoneMetrics, (el) => {
            if (overlapsReservedZones(el)) {
                el.style.left = el.dataset.lastValidLeft || el.style.left;
                el.style.top = el.dataset.lastValidTop || el.style.top;
                return;
            }

            el.dataset.lastValidLeft = el.style.left;
            el.dataset.lastValidTop = el.style.top;
        });

        const removeBtn = wrapper.querySelector('.remove-item');
        if (removeBtn) {
            removeBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                wrapper.remove();
                updateExtrasCount();
                updateEmptyState();
                updateSummary();
            });
        }

        updateExtrasCount();
        updateEmptyState();
        updateSummary();
    }

    function applyColor(color, imageUrl = '') {
        selectedColor = color || '';

        if (baseProductImage) {
            if (imageUrl && imageUrl.trim() !== '') {
                baseProductImage.src = imageUrl;
            } else if (originalBaseImage) {
                baseProductImage.src = originalBaseImage;
            }
        }

        if (colorLayer) {
            colorLayer.style.backgroundColor = 'transparent';
            colorLayer.style.opacity = '0';
        }

        colorButtons.forEach((btn) => {
            btn.classList.remove('ring-2', 'ring-pink-400', 'ring-offset-2');

            if ((btn.dataset.color || '').trim() === selectedColor) {
                btn.classList.add('ring-2', 'ring-pink-400', 'ring-offset-2');
            }
        });

        updateSummary();
    }

    function rebuildCardArea() {
        renderCardZone();
        renderCardTemplate();
        updateCardText();
    }

    function rebuildPhotoArea() {
        renderPhotoFrame();
    }

    function rebuildExtrasArea() {
        renderExtrasZone();

        itemsLayer.querySelectorAll('.design-item').forEach((item) => {
            const rect = item.getBoundingClientRect();
            const parent = designArea.getBoundingClientRect();

            const currentLeft = rect.left - parent.left;
            const currentTop = rect.top - parent.top;
            const clamped = clampToMetrics(currentLeft, currentTop, rect.width, rect.height, getExtrasZoneMetrics());

            item.style.left = `${clamped.left}px`;
            item.style.top = `${clamped.top}px`;

            if (!overlapsReservedZones(item)) {
                item.dataset.lastValidLeft = item.style.left;
                item.dataset.lastValidTop = item.style.top;
            }
        });
    }

    addButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const alreadyInCanvas = itemsLayer.querySelector(`.design-item[data-extra-id="${btn.dataset.extraId || ''}"]`);

            if (!alreadyInCanvas) {
                addExtra(btn);
            }
        });
    });

    colorButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const color = btn.dataset.color || '';
            const imageUrl = btn.dataset.image || '';
            applyColor(color, imageUrl);
        });
    });

    if (photoInput) {
        photoInput.addEventListener('change', async (e) => {
            const file = e.target.files && e.target.files[0] ? e.target.files[0] : null;
            if (!file) return;
            await handlePhotoChange(file);
        });
    }

    if (fraseInput) {
        fraseInput.addEventListener('input', renderTexts);
    }

    if (dedicatoriaInput) {
        dedicatoriaInput.addEventListener('keydown', (e) => {
            const maxWords = parseInt(dedicatoriaInput.dataset.maxWords || '20', 10);
            const words = (dedicatoriaInput.value || '').match(/\S+/g) || [];

            const allowedKeys = [
                'Backspace', 'Delete', 'ArrowLeft', 'ArrowRight',
                'ArrowUp', 'ArrowDown', 'Tab',
            ];

            if (allowedKeys.includes(e.key)) return;

            if (e.key === ' ' && words.length >= maxWords) {
                e.preventDefault();
                return;
            }

            if (words.length >= maxWords && e.key.length === 1) {
                e.preventDefault();
            }
        });

        dedicatoriaInput.addEventListener('input', () => {
            renderTexts();
        });
    }

    if (destinatarioInput) {
        destinatarioInput.addEventListener('input', renderTexts);
    }

    if (photoAdjustWindow && photoAdjustImage) {
        makePhotoDraggable(photoAdjustWindow, photoAdjustImage);
    }

    if (photoZoomRange) {
        photoZoomRange.min = '1';
        photoZoomRange.max = '5';
        photoZoomRange.step = '0.01';

        photoZoomRange.addEventListener('input', () => {
            photoState.scale = parseFloat(photoZoomRange.value || '1');
            clampPhotoOffsets(photoAdjustWindow);
            updateAdjustImageTransform();
        });
    }

    if (closePhotoAdjustModal) {
        closePhotoAdjustModal.addEventListener('click', () => {
            closeAdjustModal();
        });
    }

    if (photoAdjustModal) {
        photoAdjustModal.addEventListener('click', (e) => {
            if (e.target === photoAdjustModal) {
                closeAdjustModal();
            }
        });
    }

    if (savePhotoAdjust) {
        savePhotoAdjust.addEventListener('click', () => {
            closeAdjustModal();
            renderPhotoFrame();
            updateSummary();
        });
    }
    if (restoreCardBtn) {
    restoreCardBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();

        cardEnabled = true;

        const oldZone = document.getElementById('card-zone');
        if (oldZone) oldZone.remove();

        renderCardZone();
        renderCardTemplate();
        updateCardText();

        restoreCardBtn.classList.add('hidden');

        updateCounters();
        updateEmptyState();
        updateSummary();
    });
}

   window.addEventListener('resize', () => {
    renderExtrasZone();

    renderCardZone();

    if (cardEnabled) {
        renderCardTemplate();
        updateCardText();
    }

    rebuildPhotoArea();
    rebuildExtrasArea();

    if (photoAdjustModal && !photoAdjustModal.classList.contains('hidden')) {
        syncAdjustStage();
    }
});

renderExtrasZone();

renderCardZone();

if (cardEnabled) {
    renderCardTemplate();
    updateCardText();
}

rebuildPhotoArea();
renderTexts();
updateExtrasCount();
updateEmptyState();
updateSummary();
});
