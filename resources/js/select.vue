<template>
    <p>Vueコンポーネントのテスト1</p>
    <p>ドロップダウンメニューが下に表示されます。</p>
    <select v-model="selectedFruits">
        <option disabled value="">果物一覧</option>
        <option v-for="fruit in optionFruits"
            v-bind:value="fruit.name"
            v-bind:key="fruit.id">
        {{ fruit.name }}
        </option>
    </select>
</template>

<script>
    export default {
        data() {
            return {
            selectedFruits: '',
            optionFruits: [
                { id: 1, name: 'りんご' },
                { id: 2, name: 'みかん' },
                { id: 3, name: 'ぶどう' }
            ],
            }
        }
    };
</script>
