export function showMoreLess(container, itemClass, showCount, buttonClass) {
    const containers = document.querySelectorAll(container);
    const loadMoreButtons = document.querySelectorAll(container + ' .' + buttonClass);

    containers.forEach(function (container, index) {
        const items = container.querySelectorAll('.' + itemClass);
        let isHidden = true;

        if (items.length > showCount) {
            for (let i = 0; i < showCount; i++) {
                items[i].classList.add(itemClass + '--show');
            }

            loadMoreButtons[index].addEventListener('click', function (event) {
                event.preventDefault();

                if (isHidden) {
                    for (let i = showCount; i < items.length; i++) {
                        items[i].classList.add(itemClass + '--show');
                    }
                    isHidden = false;
                    loadMoreButtons[index].querySelector('span').textContent = 'Show Less';
                    loadMoreButtons[index].classList.add(buttonClass + '--more');
                } else {
                    for (let i = showCount; i < items.length; i++) {
                        items[i].classList.remove(itemClass + '--show');
                    }
                    isHidden = true;
                    loadMoreButtons[index].querySelector('span').textContent = 'Show More';
                    loadMoreButtons[index].classList.remove(buttonClass + '--more');
                }
            });
        } else {
            for (let i = 0; i < items.length; i++) {
                items[i].classList.add(itemClass + '--show');
            }

            loadMoreButtons[index].classList.add(buttonClass + '--hide');
        }
    });
}
