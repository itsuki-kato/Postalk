<template>
    <p>Vueコンポーネントのテスト2</p>
    <p>下のボタンをクリックするとアラートが表示されます。</p>
    <button class="border rounded" @click="showAlert">show alert!</button>
</template>

<script>
    export default {
        setup() {
            const showAlert = () => {
                alert('テストアラート表示')
            }

            return {
                showAlert
            }
        },
    }
</script>
