<template>
    <CardComponent :title="'Configuraciones Checklists'">
        <template #body>
            <tabs-Container>
                <template #tabs>
                    <li class="nav-item" v-for="(tab, index) in tabs" :key="tab.id">
                        <a :class="['nav-link', { 'active': tab.active }]"
                           :id="`${tab.id}-tab`"
                           data-toggle="tab"
                           :href="tab.href"
                           role="tab"
                           :aria-controls="tab.ariaControls"
                           :aria-selected="tab.ariaSelected"
                           @click="changeTab(index)">
                            {{ tab.title }}
                        </a>
                    </li>
                </template>
                <template #tab-content>
                    <div v-for="tabContent in tabContents" :key="tabContent.id"
                         :class="['tab-pane', 'fade', { 'show active': tabContent.active }]"
                         :id="tabContent.id" role="tabpanel"
                         :aria-labelledby="tabContent.ariaLabelledby">
                        <component :is="tabContent.component"></component>
                    </div>
                </template>
            </tabs-Container>
        </template>
    </CardComponent>
</template>

<script>
import {defineAsyncComponent, ref} from 'vue';
import {tabsCheck,tabContentCheck} from "@/data/tabChecklist";
import CardComponent from "@/components/CardComponent.vue";
import TabsContainer from "@/components/TabsContainer.vue";


const Categorias = defineAsyncComponent(() => import('./tabs/Categorias.vue'));
const Tipos = defineAsyncComponent(() => import('./tabs/Tipos.vue'));
const Items = defineAsyncComponent(() => import('./tabs/Items.vue'));
export default {
    components:{
        CardComponent,
        TabsContainer,
        Items,
        Categorias,
        Tipos
    },
    data() {
        return {
            tabs: tabsCheck,
            tabContents: tabContentCheck
        }
    },
    methods: {
        changeTab(index) {
            this.tabs.forEach((tab, i) => {
                tab.active = i === index;
            });
            this.tabContents.forEach((content, i) => {
                content.active = i === index;
            });
        }
    }
}
</script>

<style scoped>

</style>


