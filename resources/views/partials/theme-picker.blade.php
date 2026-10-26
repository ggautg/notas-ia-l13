<div x-data="themePicker()" x-init="init()" class="theme-switcher">
    <div x-show="open" x-cloak x-transition.opacity.duration.150ms @click.outside="open = false"
        class="theme-switcher__menu">
        <p class="theme-switcher__heading">Tema de la interfaz</p>

        <template x-for="t in themes" :key="t.id">
            <button type="button" class="theme-option" :class="theme === t.id ? 'is-active' : ''"
                @click="setTheme(t.id)">
                <span class="theme-option__icon" x-text="t.icon"></span>
                <span class="flex-1">
                    <span class="theme-option__name" x-text="t.name"></span>
                    <span class="theme-option__hint" x-text="t.hint"></span>
                </span>
                <span class="theme-option__dot" :style="`background:${t.color}; color:${t.color}`"></span>
            </button>
        </template>
    </div>

    <button type="button" class="theme-switcher__toggle" @click="open = !open"
        :aria-label="'Cambiar tema (actual: ' + currentName + ')'">
        <span x-text="currentIcon"></span>
        <span class="theme-switcher__label" x-text="currentName"></span>
    </button>
</div>

<script>
    function themePicker() {
        const key = 'notas-theme';

        return {
            open: false,
            theme: 'gothic',
            themes: [
                { id: 'white', name: 'White', hint: 'Claro y limpio', icon: '☀', color: '#4f46e5' },
                { id: 'dark', name: 'Dark', hint: 'Negro absoluto', icon: '🌑', color: '#818cf8' },
                { id: 'gothic', name: 'Gothic Nun', hint: 'Bien Dark', icon: '✝', color: '#a78bfa' },
                { id: 'hellsinger', name: 'Hellsinger', hint: 'Sangre y metal', icon: '🔥', color: '#ff2d40' },
                { id: 'rainbow', name: 'Happy Rainbow', hint: 'Pastel y color', icon: '🌈', color: '#ff3d9a' },
            ],

            init() {
                this.theme = document.documentElement.dataset.theme || 'gothic';
                window.addEventListener('themechange', (event) => {
                    this.theme = event.detail;
                });
            },

            setTheme(id) {
                this.theme = id;
                document.documentElement.dataset.theme = id;
                try {
                    localStorage.setItem(key, id);
                } catch (e) { /* ignore */ }
                window.dispatchEvent(new CustomEvent('themechange', { detail: id }));
            },

            get currentIcon() {
                const found = this.themes.find((t) => t.id === this.theme);
                return found ? found.icon : '✝';
            },

            get currentName() {
                const found = this.themes.find((t) => t.id === this.theme);
                return found ? found.name : 'Gothic Nun';
            },
        };
    }
</script>
