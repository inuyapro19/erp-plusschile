import state from './state'
import * as mutations from './mutations'
import * as actions from './actions'

const namespaced = true

export default {
    namespaced,
    state,
    mutations,
    actions
}
