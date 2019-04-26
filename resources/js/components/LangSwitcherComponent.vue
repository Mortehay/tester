<template>
    <div>
        lang switcher test {{currentLang}}
        <ul>
            <li v-for="lang in langs">
                <a v-on:click="langChange" :data-lang="lang" :class="{ 'uk-active' : lang != currentLang , 'uk-disabled' : lang == currentLang}">{{lang.toUpperCase()}}</a>
            </li>
        </ul>
    </div>

</template>

<script>
    export default {
        name: "lang",
        data() {
            return {
                langs:[],
                lang:'',
                currentLang:'',
            };
        },
        created() {
            this.fetchLangs();
        },
        methods:{
            fetchLangs(){
                let vm = this;

                let page_url = '/api/langs';
                fetch(page_url)
                    .then(res => res.json())
                    .then(res =>{
                        //console.log(res);
                        this.langs = res;
                        let currentLang = (window.location.pathname).split('/')[1];
                        if((this.langs).indexOf(currentLang) > -1) {
                            this.currentLang = currentLang;
                        } else {
                            this.currentLang = 'en';
                        }
                    })
                    .catch(err => console.log(err));
                /**/
            },
            langChange(event){
                //console.log('lang', event.target.dataset.lang);
                let vm = this;
                let lang = event.target.dataset.lang;
                this.lang = lang;

                let currentLang = (window.location.pathname).split('/')[1];
                if((this.langs).indexOf(currentLang) > -1) {
                    this.currentLang = currentLang;
                } else {
                    this.currentLang = 'en';
                }
                if(this.currentLang != this.lang){

                    let page_url = `/api/langs/${lang}`;
                    console.log('fetch');
                    fetch(page_url)
                        .then(res => res.json())
                        .then(res =>{
                            console.log(res);
                            let tempUrl = (window.location.pathname).split('/');
                            let tempPathname = window.location.pathname;
                            console.log(tempUrl);
                            console.log(this.currentLang);
                            //this.fetchLangs();
                            console.log(this.langs);
                            //if(res.data == 'success')
                            //this.langs = res;
                            if(this.currentLang == 'en' && this.lang != 'en'){
                                tempPathname = '/' + this.lang + tempPathname;
                                location.href = window.location.origin + tempPathname;
                                //console.log(tempPathname);
                            }
                            if(this.currentLang != 'en' && this.lang == 'en'){
                                tempPathname = tempPathname.replace('/' + this.currentLang, '');
                                location.href = window.location.origin + tempPathname;
                                //console.log(tempPathname);
                            }
                            if(this.currentLang != 'en' && this.lang != 'en'){
                                tempPathname = tempPathname.replace('/' + this.currentLang, '/' + this.lang);
                                location.href = window.location.origin + tempPathname;
                                //console.log(tempPathname);
                            }
                        })
                        .catch(err => console.log(err));
                }

            }
        }
    }
</script>

<style scoped>

</style>