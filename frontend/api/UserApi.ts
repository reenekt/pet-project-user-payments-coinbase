import {AxiosInstance} from 'axios'
import {
  User,
  UserSaveData,
  UserStoreData,
  UserUpdateData,
  UserStoreResult,
  UserUpdateResult,
  UserDeleteResult,
} from "@/api/User";

class UserApi {
  static basePath = '/users'
  public axios: AxiosInstance;

  constructor(axios: AxiosInstance) {
    this.axios = axios
  }

  /**
   * List of users
   */
  async all() {
    return this.axios.get<User[]>(UserApi.basePath)
  }

  /**
   * User details
   *
   * @param id
   */
  async show(id: number | string) {
    return this.axios.get<{ user: User }>(`${UserApi.basePath}/${id}`)
  }

  /**
   * Create new user
   *
   * @param data
   */
  async store(data: UserStoreData) {
    return this.axios.post<UserStoreResult>(UserApi.basePath, data)
  }

  /**
   * Update user by ID
   *
   * @param id
   * @param data
   */
  async update(id: number | string, data: UserUpdateData) {
    return this.axios.put<UserUpdateResult>(`${UserApi.basePath}/${id}`, data)
  }

  /**
   * Delete user by id
   *
   * @param id
   */
  async delete(id: number | string) {
    return this.axios.delete<UserDeleteResult>(`${UserApi.basePath}/${id}`)
  }
}

export default UserApi
