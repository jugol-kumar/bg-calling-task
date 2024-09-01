<template>
  <Bar :data="data" :options="options" />
</template>

<script lang="ts">
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
} from 'chart.js'
import { Line, Bar } from 'vue-chartjs'
import * as chartConfig from './data.js'
import {options} from "./data.js"
ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend)

export default {
  name: 'App',
  components: {
    Bar,
    Line
  },
  setup(props, ctx) {
      return {options}
  },
  data() {
    return chartConfig
  }
}
</script>
