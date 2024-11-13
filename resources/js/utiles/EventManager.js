class EventManager {
    constructor() {
        this.eventHandlers = new Map(); // Dinleyicileri saklamak için bir Map
    }

    on(target, selector, event, handler) {
        // Eğer hedef üzerinde zaten bir dinleyici varsa, mevcut olanı kullan
        if (!this.eventHandlers.has(target)) {
            this.eventHandlers.set(target, new Map());
        }

        const eventDelegator = (e) => this.delegateEvent(e, target, selector, event);

        // Hedefin event'leri için bir Map oluşturuluyor (event bazında)
        if (!this.eventHandlers.get(target).has(event)) {
            this.eventHandlers.get(target).set(event, []);
        }

        // Bu event'e ait dinleyiciyi ekliyoruz
        const eventList = this.eventHandlers.get(target).get(event);
        eventList.push({ selector, handler, eventDelegator });

        // Hedefin event'e ait dinleyiciyi ekle
        if (eventList.length === 1) {
            target.addEventListener(event, eventDelegator);
        }
    }

    delegateEvent(e, target, selector, event) {
        const eventList = this.eventHandlers.get(target).get(event);
        eventList.forEach(({ selector, handler }) => {
            const elements = target.querySelectorAll(selector);
            elements.forEach(element => {
                if (element.contains(e.target) || element === e.target) {
                    handler.call(element, e); // Dinleyiciyi çağır
                }
            });
        });
    }

    off(target, selector, event) {
        if (this.eventHandlers.has(target) && this.eventHandlers.get(target).has(event)) {
            const eventList = this.eventHandlers.get(target).get(event);

            // Dinleyici silme işlemi
            const eventDelegator = eventList.find(handler => handler.selector === selector)?.eventDelegator;
            if (eventDelegator) {
                target.removeEventListener(event, eventDelegator);
                const index = eventList.findIndex(handler => handler.selector === selector);
                eventList.splice(index, 1); // Seçiciye göre dinleyiciyi kaldır

                // Eğer hedef üzerinde başka event kalmadıysa, hedefi temizle
                if (eventList.length === 0) {
                    this.eventHandlers.get(target).delete(event);
                    if (this.eventHandlers.get(target).size === 0) {
                        this.eventHandlers.delete(target);
                    }
                }
            }
        }
    }
}

export default EventManager;
