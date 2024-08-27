<template>
    <div>
        <div class="row my-5 mx-5">
            <div class="col-md-6 mb-2">
                <label class="fs-6 fw-semibold mb-2">Banco</label>
                <select v-model="selectedBankId" class="form-select form-select-solid">
                    <option disabled value="">---Seleccione---</option>
                    <option v-for="banco in bancos" :key="banco.id" :value="banco.id">
                        {{ banco.nombre_banco }}
                    </option>
                </select>
            </div>

            <div class="col-md-6 mb-2">
                <label class="fs-6 fw-semibold mb-2">Tipo de Cuenta</label>
                <select v-model="bankAccount.tipo_cuenta" class="form-select form-select-solid">
                    <option disabled value="">---Seleccione---</option>
                    <option v-for="type in accountTypes" :key="type.value" :value="type.value">
                        {{ type.name }}
                    </option>
                </select>
            </div>

            <div class="col-md-6 mb-2">
                <label class="fs-6 fw-semibold mb-2">Número de Cuenta</label>
                <input
                    v-model="bankAccount.nro_cuenta"
                    class="form-control form-control-solid"
                    type="text"
                />
            </div>

            <div class="col-md-6 mb-2">
                <label class="fs-6 fw-semibold mb-2">Fecha de Ingreso</label>
                <input
                    v-model="bankAccount.fecha_ingreso_cuenta"
                    class="form-control form-control-solid"
                    type="date"
                />
            </div>

            <div class="col-md-8 mb-2">
                <label class="fs-6 fw-semibold mb-2">Es predeterminado</label>
                <label class="form-check form-switch form-check-custom form-check-solid">
                    <input
                        v-model="bankAccount.isDefault"
                        class="form-check-input"
                        type="checkbox"
                    />
                    <span class="form-check-label fw-semibold text-muted">Activar</span>
                </label>
            </div>
        </div>

        <div class="row my-5 mx-5">
            <div class="col-md-12">
                <button
                    type="button"
                    class="btn btn-primary btn-sm"
                    @click="isEditing ? updateBankAccount() : addBankAccount()"
                >
                    {{ isEditing ? 'Actualizar' : 'Agregar' }}
                </button>
            </div>
        </div>

        <div class="row mt-3 mb-5">
            <div class="col-md-12">
                <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5 dataTable no-footer">
                    <thead>
                    <tr>
                        <th>Nro Cuenta</th>
                        <th>Tipo de cuenta</th>
                        <th>Banco</th>
                        <th>Fecha Ingreso Cuenta</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(banco, index) in bankAccounts" :key="index">
                        <td>{{ banco.nro_cuenta }}</td>
                        <td>{{ banco.tipo_cuenta }}</td>
                        <td>{{ banco.nombre_banco }}</td>
                        <td>{{ new Date(banco.fecha_ingreso_cuenta).toLocaleDateString() }}</td>
                        <td>
                            <button
                                type="button"
                                class="btn btn-sm"
                                :class="banco.isDefault ? 'btn-success' : 'btn-default'"
                                title="Predeterminado"
                            >
                                <i class="fa fa-star"></i>
                            </button>
                            <button
                                type="button"
                                class="btn btn-sm btn-danger"
                                @click="deleteBankAccount(banco.id)"
                                title="Eliminar"
                            >
                                <i class="fa fa-trash"></i>
                            </button>
                            <button
                                type="button"
                                class="btn btn-sm btn-info"
                                @click="getBankAccount(banco.id)"
                                title="Editar"
                            >
                                <i class="fa fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapState} from "vuex";

export default {
    props: {
        form: {
            type: Object,
            required: true,
        },
        isEdit: {
            type: Boolean,
            required: false,
            default: false,
        },
    },
    data() {
        return {
            bankAccounts: [],
            bankAccount: {
                id: null,
                nombre_banco: '',
                banco_id: '',
                tipo_cuenta: '',
                nro_cuenta: '',
                fecha_ingreso_cuenta: '',
                isDefault: false,
            },
            isEditing: false,
            accountTypes: [
                {name: 'Cuenta Ahorros', value: 'cuenta de ahorro'},
                {name: 'Cuenta Corriente', value: 'cuenta corriente'},
                {name: 'Cuenta Vista', value: 'cuenta vista'},
                {name: 'Chequera Electrónica', value: 'chequera electrónica'},
            ],
        };
    },
    computed: {
        ...mapState({
            // Aquí se podrían mapear los datos necesarios desde el store
            bancos: state => state.bancos.bancos,
        }),
        selectedBankId: {
            get() {
                return this.bankAccount.banco_id;
            },
            set(value) {
                this.bankAccount.banco_id = value;
                const selectedBank = this.bancos.find(banco => banco.id === value);
                this.bankAccount.nombre_banco = selectedBank ? selectedBank.nombre_banco : '';
            },
        },
    },
    watch: {
        'form.bancos': {
            immediate: true,
            handler(bancos) {
                if(this.isEdit && Array.isArray(bancos)) {
                    this.bankAccounts = [...bancos];
                }
            }
        }
    },
    methods: {
        ...mapActions({
            // Aquí se podrían mapear las acciones necesarias desde el store
            fetchBanks: 'bancos/fetchBancos',
        }),

        resetForm() {
            this.bankAccount = {
                id: null,
                nombre_banco: '',
                banco_id: '',
                tipo_cuenta: '',
                nro_cuenta: '',
                fecha_ingreso_cuenta: '',
                isDefault: false,
            };
            this.isEditing = false;
        },
        addBankAccount() {
            if (!this.bankAccount.banco_id || !this.bankAccount.tipo_cuenta || !this.bankAccount.nro_cuenta || !this.bankAccount.fecha_ingreso) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Por favor, complete todos los campos requeridos.',
                });
                return;
            }

            const newBankAccount = {...this.bankAccount, id: Date.now()};
            this.bankAccounts.push(newBankAccount);
            this.form.bancos = [...this.bankAccounts];
            this.resetForm();

            Swal.fire({
                icon: 'success',
                title: '¡Añadido!',
                text: 'La cuenta bancaria ha sido añadida exitosamente.',
            });
        },
        updateBankAccount() {
            const index = this.bankAccounts.findIndex(account => account.id === this.bankAccount.id);
            if (index !== -1) {
                this.$set(this.bankAccounts, index, {...this.bankAccount});
                this.form.bancos = [...this.bankAccounts];
                this.resetForm();

                Swal.fire({
                    icon: 'success',
                    title: 'Actualizado',
                    text: 'La cuenta bancaria ha sido actualizada exitosamente.',
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se encontró la cuenta bancaria para actualizar.',
                });
            }
        },
        deleteBankAccount(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, bórralo!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const index = this.bankAccounts.findIndex(account => account.id === id);
                    if (index !== -1) {
                        this.bankAccounts.splice(index, 1);
                        this.form.bancos = [...this.bankAccounts];

                        Swal.fire({
                            icon: 'success',
                            title: 'Eliminado',
                            text: 'La cuenta bancaria ha sido eliminada exitosamente.',
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se encontró la cuenta bancaria para eliminar.',
                        });
                    }
                }
            })
        },
        getBankAccount(id) {
            const bankAccount = this.bankAccounts.find(account => account.id === id);
            if (bankAccount) {
                this.bankAccount = {...bankAccount};
                this.isEditing = true;
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se encontró la cuenta bancaria.',
                });
            }
        },
    },
    mounted() {
        this.fetchBanks()
    },
};
</script>

