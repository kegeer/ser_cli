import {Bar} from 'vue-chartjs'
export default Bar.extend({
  mounted () {
    this.renderChart({
      labels: ['12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32'],
      datasets: [
        {
          label: 'blue',
          backgroundColor: '#f87979',
          borderWidth: 20,
          borderColor: 'transparent',
          data: [
            120.969,
            100.36,
            162.989,
            96.0349,
            84.5127,
            27.8399,
            19.3904,
            7.80982,
            10.2471,
            0.433577,
            91.7915,
            33.2585,
            76.6155,
            35.654,
            14.2834,
            32.4575
          ]
        }, {
          label: 'blue',
          backgroundColor: '#f879ff',
          borderWidth: 20,
          borderColor: 'transparent',
          data: [75.8604, 57.6834, 214.058, 353.314, 266.256, 205.908, 272.962, 1674.36, 2379.65, 2894.09, 1.32028]
        }
      ]
    })
  }
})
