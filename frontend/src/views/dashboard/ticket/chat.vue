<template>
    <div class="flex space-x-5 chat-height overflow-hidden relative rtl:space-x-reverse">
        
    
        <div class="flex-1">
            <div class="parent flex space-x-5 h-full rtl:space-x-reverse">
                <div class="" :class="'flex-1'">
                    <Card bodyClass="p-0 h-full" className="h-full">
                        <Chats/>
                    </Card>
                </div>
                <div class="flex-none w-[485px]" v-if="window.width > 1280
                    ">
                    <Card bodyClass="p-0 h-full">
                        <infomation />
                    </Card>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Card from "@/components/Card";
import Icon from "@/components/Icon";
import infomation from "./Info.vue";
import Chats from "./Message.vue";
import window from "@/mixins/window";

export default {
    mixins: [window],
    components: {
        Card,
        Icon,
        infomation,
        Chats,
    },

    methods: {
        
    },
    computed: {
        
    }
};
</script>
<style lang="scss" scoped>
.chat-height {
    height: calc(var(--vh, 1vh) * 100 - 12.1rem);
}

@media (max-width: 768px) {
    .chat-height {
        height: calc(var(--vh, 1vh) * 100 - 10.5rem);
    }
}

.contact-height {
    height: calc(100% - 138px);
}
</style>
