import {AxiosInstance} from 'axios'
import {Payment} from '@/api/Payment'
import {User} from "~/api/User";

class PaymentApi {
  static basePath = '/users/0/payments'
  public axios: AxiosInstance;
  public userId: number | string;

  constructor(axios: AxiosInstance, userId: number | string) {
    if (!userId) {
      throw Error('User ID not set')
    }

    this.axios = axios
    this.userId = userId
    PaymentApi.basePath = `/users/${this.userId}/payments`
  }

  /**
   * List of users
   */
  async all() {
    return this.axios.get<Payment[]>(PaymentApi.basePath)
  }

  /**
   * User details
   *
   * @param id
   */
  async show(id: number | string) {
    return this.axios.get<{
      user: User
      payment: Payment
    }>(`${PaymentApi.basePath}/${id}`)
  }
}

export default PaymentApi
