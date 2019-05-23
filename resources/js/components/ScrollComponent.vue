<template>
    <div>
        <a v-if="scrolled" class="scroll" uk-icon="icon: chevron-up; ratio: 3" @scroll="handleScroll" v-scroll-to="{ el: '#app', offset: -70, }"><!--{{ $t('texts.scroll.title')}}--></a>
    </div>
</template>

<script>
    export default {
        name: "scroll",
        props:{

        },
        data() {
            return {
                windowHeight: 0,
                scrolled: false,
            };
        },
        methods: {
            handleScroll: function (event) {
                this.windowHeight = window.pageYOffset;
                if(window.pageYOffset > 70) {
                    this.scrolled = true;
                } else {
                    this.scrolled = false;
                }

            }
        },

        created: function () {
            window.addEventListener('scroll', this.handleScroll);
        },
        destroyed: function () {
            window.removeEventListener('scroll', this.handleScroll);
        }
    }
</script>

<style scoped>

</style>