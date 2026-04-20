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

    const addButtons = document.querySelectorAll('.add-extra-btn');
    const colorButtons = document.querySelectorAll('.color-swatch');

    const fraseInput = document.getElementById('input-frase');
    const dedicatoriaInput = document.getElementById('input-dedicatoria');
    const destinatarioInput = document.getElementById('input-destinatario');

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
        (designArea && designArea.dataset.cardTemplate) ||
        (editorWrapper && editorWrapper.dataset.cardTemplate) ||
        '/storage/cards/tarjeta-base.png';

    const frameVertical =
        (designArea && designArea.dataset.frameVertical) ||
        (editorWrapper && editorWrapper.dataset.frameVertical) ||
        '';

    const frameHorizontal =
        (designArea && designArea.dataset.frameHorizontal) ||
        (editorWrapper && editorWrapper.dataset.frameHorizontal) ||
        '';

    let selectedColor = '';
    const originalBaseImage = baseProductImage ? baseProductImage.getAttribute('src') : '';

    let cardZone = null;
    let cardWrapper = null;

    let photoState = {
        src: '',
        orientation: 'vertical',
        objectUrl: null,
        offsetX: 0,
        offsetY: 0,
        scale: 1.12,
    };

    if (!designArea || !itemsLayer || !textLayer) {
        return;
    }

    if (baseProductImage && originalBaseImage) {
        baseProductImage.addEventListener('error', () => {
            baseProductImage.src = originalBaseImage;
        });
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
            items: items,
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

    function clampPosition(left, top, elWidth, elHeight, boundsEl = designArea) {
        const maxLeft = Math.max(0, boundsEl.clientWidth - elWidth);
        const maxTop = Math.max(0, boundsEl.clientHeight - elHeight);

        return {
            left: Math.max(0, Math.min(left, maxLeft)),
            top: Math.max(0, Math.min(top, maxTop)),
        };
    }

    function makeDraggable(el, boundsEl = designArea, onMoveEnd = null) {
        let isDragging = false;
        let offsetX = 0;
        let offsetY = 0;

        const onMouseMove = (e) => {
            if (!isDragging) return;

            const parentRect = boundsEl.getBoundingClientRect();
            const elRect = el.getBoundingClientRect();

            const left = e.clientX - parentRect.left - offsetX;
            const top = e.clientY - parentRect.top - offsetY;

            const clamped = clampPosition(left, top, elRect.width, elRect.height, boundsEl);

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
                onMoveEnd();
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

            el.style.zIndex = '60';
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
        const width = designArea.clientWidth;
        const height = designArea.clientHeight;

        return {
            left: width * 0.22,
            top: height * 0.72,
            zoneWidth: width * 0.34,
            zoneHeight: height * 0.18,
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
        cardZone.style.width = `${metrics.zoneWidth}px`;
        cardZone.style.height = `${metrics.zoneHeight}px`;

        designArea.appendChild(cardZone);
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

    function ensureCardInsideZone() {
        if (!cardWrapper || !cardZone) return;

        const cardRect = cardWrapper.getBoundingClientRect();

        const clamped = clampPosition(
            parseFloat(cardWrapper.style.left || '0'),
            parseFloat(cardWrapper.style.top || '0'),
            cardRect.width,
            cardRect.height,
            cardZone
        );

        cardWrapper.style.left = `${clamped.left}px`;
        cardWrapper.style.top = `${clamped.top}px`;
    }

    function renderCardTemplate() {
        if (!cardZone) return;

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
        `;

        cardZone.appendChild(cardWrapper);
        makeDraggable(cardWrapper, cardZone, ensureCardInsideZone);
        updateCardText();
    }

    function getPhotoZoneMetrics() {
        if (photoGuideZone) {
            return {
                left: photoGuideZone.offsetLeft - (photoGuideZone.offsetWidth * 0.06),
                top: photoGuideZone.offsetTop - (photoGuideZone.offsetHeight * 0.10),
                zoneWidth: photoGuideZone.offsetWidth * 1.55,
                zoneHeight: photoGuideZone.offsetHeight * 1.70,
            };
        }

        const width = designArea.clientWidth;
        const height = designArea.clientHeight;

        return {
            left: width * 0.60,
            top: height * 0.03,
            zoneWidth: width * 0.18,
            zoneHeight: height * 0.36,
        };
    }

    function getFrameSrc() {
        return photoState.orientation === 'horizontal'
            ? (frameHorizontal || frameVertical)
            : (frameVertical || frameHorizontal);
    }

    function getPhotoInset() {
        if (photoState.orientation === 'horizontal') {
            return {
                top: '12%',
                right: '14%',
                bottom: '24%',
                left: '14%',
                radius: '10px',
            };
        }

        return {
            top: '4%',
            right: '20%',
            bottom: '28%',
            left: '20%',
            radius: '10px',
        };
    }

    function getAdjustWindowByOrientation() {
        if (photoState.orientation === 'horizontal') {
            return {
                left: '15%',
                top: '13%',
                width: '70%',
                height: '53%',
                radius: '12px',
            };
        }

        return {
            left: '20%',
            top: '7%',
            width: '60%',
            height: '64%',
            radius: '12px',
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

        photoZoomRange.value = String(photoState.scale);
        clampPhotoOffsets(photoAdjustWindow);
        updateAdjustImageTransform();
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

        syncAdjustStage();

        photoAdjustModal.classList.remove('hidden');
        photoAdjustModal.classList.add('flex');
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

        if (!photoState.src) {
            updateEmptyState();
            updateSummary();
            return;
        }

        const metrics = getPhotoZoneMetrics();
        const frameSrc = getFrameSrc();
        const inset = getPhotoInset();

        const wrapper = document.createElement('div');
        wrapper.id = 'photo-frame-wrapper';
        wrapper.className = 'absolute';
        wrapper.style.left = `${metrics.left}px`;
        wrapper.style.top = `${metrics.top}px`;
        wrapper.style.width = `${metrics.zoneWidth}px`;
        wrapper.style.height = `${metrics.zoneHeight}px`;
        wrapper.style.zIndex = '25';
        wrapper.style.pointerEvents = 'none';

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
        updateEmptyState();
        updateSummary();
    }

    function detectImageOrientation(file) {
        return new Promise((resolve) => {
            const tempUrl = URL.createObjectURL(file);
            const img = new Image();

            img.onload = () => {
                const orientation = img.width >= img.height ? 'horizontal' : 'vertical';
                URL.revokeObjectURL(tempUrl);
                resolve(orientation);
            };

            img.onerror = () => {
                URL.revokeObjectURL(tempUrl);
                resolve('vertical');
            };

            img.src = tempUrl;
        });
    }

    async function handlePhotoChange(file) {
        if (!file || !photoLayer) return;

        if (photoState.objectUrl) {
            URL.revokeObjectURL(photoState.objectUrl);
            photoState.objectUrl = null;
        }

        const orientation = await detectImageOrientation(file);
        const objectUrl = URL.createObjectURL(file);

        photoState.src = objectUrl;
        photoState.objectUrl = objectUrl;
        photoState.orientation = orientation;
        photoState.offsetX = 0;
        photoState.offsetY = 0;
        photoState.scale = orientation === 'horizontal' ? 1.00 : 0.82;

        const modalOpened = openPhotoAdjustModal();

        if (!modalOpened) {
            renderPhotoFrame();
        }
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
            return { width: 160, height: 160 };
        }

        if (value.includes('peluche')) {
            return { width: 150, height: 150 };
        }

        if (value.includes('chocolate')) {
            return { width: 130, height: 130 };
        }

        if (value.includes('foto')) {
            return { width: 140, height: 140 };
        }

        return { width: 140, height: 140 };
    }

    function addExtra(btn) {
        const image = btn.dataset.extraImage || '';
        const name = btn.dataset.extraName || 'Extra';
        const extraId = btn.dataset.extraId || '';

        if (!image) return;

        const existing = itemsLayer.querySelector(`.design-item[data-extra-id="${extraId}"]`);
        if (existing) return;

        const size = getDefaultSize(name);

        const wrapper = document.createElement('div');
        wrapper.className = 'design-item absolute select-none cursor-grab group';
        wrapper.dataset.extraId = extraId;
        wrapper.dataset.extraName = name;
        wrapper.dataset.baseZ = '20';
        wrapper.style.left = '20px';
        wrapper.style.top = '20px';
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
        makeDraggable(wrapper, designArea);

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

    // 🚫 BLOQUEAR escribir más de 20 palabras
    dedicatoriaInput.addEventListener('keydown', (e) => {
        const maxWords = parseInt(dedicatoriaInput.dataset.maxWords || '20', 10);
        const words = (dedicatoriaInput.value || '').match(/\S+/g) || [];

        // Permitir borrar, flechas, etc.
        const allowedKeys = [
            'Backspace', 'Delete', 'ArrowLeft', 'ArrowRight',
            'ArrowUp', 'ArrowDown', 'Tab'
        ];

        if (allowedKeys.includes(e.key)) return;

        // Si ya llegó al límite y presiona espacio → bloquear
        if (e.key === ' ' && words.length >= maxWords) {
            e.preventDefault();
            return;
        }

        // Si ya llegó al límite y escribe letras → bloquear
        if (words.length >= maxWords && e.key.length === 1) {
            e.preventDefault();
        }
    });

    // ✔️ mantener render y contador
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
        photoZoomRange.min = '0.65';
        photoZoomRange.max = '2.2';
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

    window.addEventListener('resize', () => {
        rebuildCardArea();
        rebuildPhotoArea();

        if (photoAdjustModal && !photoAdjustModal.classList.contains('hidden')) {
            syncAdjustStage();
        }
    });

    rebuildCardArea();
    rebuildPhotoArea();
    renderTexts();
    updateExtrasCount();
    updateEmptyState();
    updateSummary();
});
