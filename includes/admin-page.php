
<div class="wrap">

    <h1><?php _e( 'Redis Object Cache', 'redis-cache' ); ?></h1>

    <div class="section-overview">

        <div>

            <h2 class="title"><?php _e( 'Overview', 'redis-cache' ); ?></h2>

            <table class="form-table">

                <?php $redisClient = $this->get_redis_client_name(); ?>
                <?php $redisDropin = $this->validate_object_cache_dropin(); ?>
                <?php $redisPrefix = $this->get_redis_cachekey_prefix(); ?>
                <?php $redisMaxTTL = $this->get_redis_maxttl(); ?>

                <?php if ( ! is_null( $redisClient ) ) : ?>
                    <tr>
                        <th><?php _e( 'Client:', 'redis-cache' ); ?></th>
                        <td>
                            <code><?php echo esc_html( $redisClient ); ?></code>

                            <?php if ( strpos( (string) $redisClient, 'predis' ) !== false ) : ?>
                                <p class="description" style="color: #d54e21; max-width: 20rem;">
                                    <?php _e( 'The Predis library is no longer maintained. Consider switching over to PhpRedis to avoid compatiblity issues in the future.', 'redis-cache' ); ?>
                                </p>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>

                <tr>
                    <th><?php _e( 'Dropin:', 'redis-cache' ); ?></th>
                    <td>
                        <code><?php echo esc_html( $redisDropin ? _e( 'Valid', 'redis-cache' ) : _e( 'Invalid', 'redis-cache' ) ); ?></code>
                    </td>
                </tr>

                <?php if ( defined( 'WP_REDIS_DISABLED' ) && WP_REDIS_DISABLED ) : ?>
                    <tr>
                        <th><?php _e( 'Disabled:', 'redis-cache' ); ?></th>
                        <td>
                            <code><?php echo _e( 'Yes', 'redis-cache' ); ?></code>
                        </td>
                    </tr>
                <?php endif; ?>

                <?php if ( ! is_null( $redisPrefix ) && trim( $redisPrefix ) !== '' ) : ?>
                    <tr>
                        <th><?php _e( 'Key Prefix:', 'redis-cache' ); ?></th>
                        <td>
                            <code><?php echo esc_html( $redisPrefix ); ?></code>
                        </td>
                    </tr>
                <?php endif; ?>

                <?php if ( ! is_null( $redisMaxTTL ) ) : ?>
                    <tr>
                        <th><?php _e( 'Max. TTL:', 'redis-cache' ); ?></th>
                        <td>
                            <code><?php echo esc_html( $redisMaxTTL ); ?></code>

                            <?php if ( ! is_int( $redisMaxTTL ) && ! ctype_digit( $redisMaxTTL ) ) : ?>
                                <p class="description" style="color: #d54e21;">
                                    <?php _e( 'This doesn’t appear to be a valid number.', 'redis-cache' ); ?>
                                </p>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>

            </table>

            <h2 class="title"><?php _e( 'Connection', 'redis-cache' ); ?></h2>

            <table class="form-table">

                <?php $diagnostics = $this->get_diagnostics(); ?>

                <tr>
                    <th><?php _e( 'Status:', 'redis-cache' ); ?></th>
                    <td><code><?php echo $this->get_status(); ?></code></td>
                </tr>

                <?php if ( ! empty( $diagnostics['host'] ) ) : ?>
                    <tr>
                        <th><?php _e( 'Host:', 'redis-cache' ); ?></th>
                        <td><code><?php echo esc_html( $diagnostics['host'] ); ?></code></td>
                    </tr>
                <?php endif; ?>

                <?php if ( isset( $diagnostics['cluster'] ) && is_array( $diagnostics['cluster'] ) ) : ?>
                    <tr>
                        <th><?php _e( 'Cluster:', 'redis-cache' ); ?></th>
                        <td>
                            <ul style="margin: 0;">
                                <?php foreach ( $diagnostics['cluster'] as $node ) : ?>
                                    <li><code><?php echo esc_html( $node ); ?></code></li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                    </tr>
                <?php endif; ?>

                <?php if ( isset( $diagnostics['shards'] ) && is_array( $diagnostics['shards'] ) ) : ?>
                    <tr>
                        <th><?php _e( 'Shards:', 'redis-cache' ); ?></th>
                        <td>
                            <ul style="margin: 0;">
                                <?php foreach ( $diagnostics['shards'] as $node ) : ?>
                                    <li><code><?php echo esc_html( $node ); ?></code></li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                    </tr>
                <?php endif; ?>

                <?php if ( isset( $diagnostics['servers'] ) && is_array( $diagnostics['servers'] ) ) : ?>
                    <tr>
                        <th><?php _e( 'Servers:', 'redis-cache' ); ?></th>
                        <td>
                            <ul style="margin: 0;">
                                <?php foreach ( $diagnostics['servers'] as $node ) : ?>
                                    <li><code><?php echo esc_html( $node ); ?></code></li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                    </tr>
                <?php endif; ?>

                <?php if ( ! empty( $diagnostics['port'] ) ) : ?>
                    <tr>
                        <th><?php _e( 'Port:', 'redis-cache' ); ?></th>
                        <td><code><?php echo esc_html( $diagnostics['port'] ); ?></code></td>
                    </tr>
                <?php endif; ?>

                <?php if ( isset( $diagnostics['password'] ) ) : ?>
                    <tr>
                        <th><?php _e( 'Password:', 'redis-cache' ); ?></th>
                        <td><code><?php echo str_repeat( '&#8226;', 8 ); ?></code></td>
                    </tr>
                <?php endif; ?>

                <?php if ( isset( $diagnostics['database'] ) ) : ?>
                    <tr>
                        <th><?php _e( 'Database:', 'redis-cache' ); ?></th>
                        <td><code><?php echo esc_html( $diagnostics['database'] ); ?></code></td>
                    </tr>
                <?php endif; ?>

                <?php if ( isset( $diagnostics['timeout'] ) ) : ?>
                    <tr>
                        <th><?php _e( 'Connection Timeout:', 'redis-cache' ); ?></th>
                        <td><code><?php echo sprintf( __( '%ss', 'redis-cache' ), $diagnostics['timeout'] ); ?></code></td>
                    </tr>
                <?php endif; ?>

                <?php if ( isset( $diagnostics['read_timeout'] ) ) : ?>
                    <tr>
                        <th><?php _e( 'Read Timeout:', 'redis-cache' ); ?></th>
                        <td><code><?php echo sprintf( __( '%ss', 'redis-cache' ), $diagnostics['read_timeout'] ); ?></code></td>
                    </tr>
                <?php endif; ?>

                <?php if ( isset( $diagnostics['retry_interval'] ) ) : ?>
                    <tr>
                        <th><?php _e( 'Retry Interval:', 'redis-cache' ); ?></th>
                        <td><code><?php echo sprintf( __( '%sms', 'redis-cache' ), $diagnostics['retry_interval'] ); ?></code></td>
                    </tr>
                <?php endif; ?>

                <tr>
                    <th><?php _e( 'Redis Version:', 'redis-cache' ); ?></th>
                    <td><code><?php echo $this->get_redis_version() ?: _e( 'Unknown', 'redis-cache' ); ?></code></td>
                </tr>

            </table>

            <p class="submit">

                <?php if ( $this->get_redis_status() ) : ?>
                    <a href="<?php echo wp_nonce_url( network_admin_url( add_query_arg( 'action', 'flush-cache', $this->page ) ), 'flush-cache' ); ?>" class="button button-primary button-large"><?php _e( 'Flush Cache', 'redis-cache' ); ?></a> &nbsp;
                <?php endif; ?>

                <?php if ( ! $this->object_cache_dropin_exists() ) : ?>
                    <a href="<?php echo wp_nonce_url( network_admin_url( add_query_arg( 'action', 'enable-cache', $this->page ) ), 'enable-cache' ); ?>" class="button button-primary button-large"><?php _e( 'Enable Object Cache', 'redis-cache' ); ?></a>
                <?php elseif ( $this->validate_object_cache_dropin() ) : ?>
                    <a href="<?php echo wp_nonce_url( network_admin_url( add_query_arg( 'action', 'disable-cache', $this->page ) ), 'disable-cache' ); ?>" class="button button-secondary button-large"><?php _e( 'Disable Object Cache', 'redis-cache' ); ?></a>
                <?php endif; ?>

            </p>

        </div>

        <br class="clearfix">

        <?php if ( ! defined( 'WP_REDIS_DISABLE_BANNERS' ) || ! WP_REDIS_DISABLE_BANNERS ) : ?>
            <h2 class="title">
                <?php _e( 'Redis Cache Pro', 'redis-cache' ); ?>
            </h2>

            <?php $isPhp7 = version_compare( phpversion(), '7.0', '>=' ); ?>
            <?php $isPhpRedis311 = version_compare( phpversion( 'redis' ), '3.1.1', '>=' ); ?>
            <?php $phpRedisInstalled = (bool) phpversion( 'redis' ); ?>

            <?php if ( $isPhp7 && $isPhpRedis311 ) : ?>
                <p>
                    <?php _e( 'Your site meets the system requirements for the Pro version (PHP 7+; PhpRedis 3.1.1+).', 'redis-cache' ); ?>
                </p>
            <?php else : ?>
                <p>
                    <?php _e( 'Your site <i>does not</i> meet the system requirements for the Pro version:', 'redis-cache' ); ?>
                </p>

                <ul style="padding-left: 30px; list-style: disc;">
                    <?php if ( ! $isPhp7 ) : ?>
                        <li>
                            <?php printf( __( 'The current version (%s) of PHP is too old. PHP 7 or newer is required.', 'redis-cache' ), phpversion() ); ?>
                        </li>
                    <?php endif; ?>

                    <?php if ( ! $phpRedisInstalled ) : ?>
                        <li>
                            <?php printf( __( 'The PhpRedis extension is not installed.', 'redis-cache' ), phpversion() ); ?>
                        </li>
                    <?php elseif ( ! $isPhpRedis311 ) : ?>
                        <li>
                            <?php printf( __( 'The current version (%s) of the PhpRedis extension is too old. PhpRedis 3.1 or newer is required.', 'redis-cache' ), phpversion( 'redis' ) ); ?>
                        </li>
                    <?php endif; ?>
                </ul>

            <?php endif; ?>
        <?php endif; ?>

        <?php if ( isset( $_GET['diagnostics'] ) ) : ?>

            <br>
            <h2 class="title">
                <?php _e( 'Diagnostics', 'redis-cache' ); ?>
            </h2>

            <textarea class="large-text readonly" rows="20" readonly><?php include dirname( __FILE__ ) . '/diagnostics.php'; ?></textarea>

        <?php else : ?>

            <p class="mt-5">
                <br>
                <a class="button button-secondary" href="<?php echo network_admin_url( add_query_arg( 'diagnostics', '1', $this->page ) ); ?>">
                    <?php _e( 'Show Diagnostics', 'redis-cache' ); ?>
                </a>
            </p>

        <?php endif; ?>

    </div>

    <div class="card">
        <h2 class="title">
            <?php _e( 'Redis Cache Pro', 'redis-cache' ); ?>
        </h2>
        <p>
            <?php _e( '<b>A business class object cache backend.</b> Truly reliable, highly-optimized and fully customizable, with a <u>dedicated engineer</u> when you most need it.', 'redis-cache' ); ?>
        </p>
        <ul>
            <li>Rewritten for raw performance</li>
            <li>WordPress object cache API compliant</li>
            <li>Easy debugging &amp; logging</li>
            <li>Cache analytics and preloading</li>
            <li>Fully unit tested (100% code coverage)</li>
            <li>Secure connections with TLS</li>
            <li>Health checks via WordPress, WP CLI &amp; Debug Bar</li>
            <li>Optimized for WooCommerce, Jetpack & Yoast SEO</li>
        </ul>
        <p>
            <a class="button button-primary" target="_blank" rel="noopener" href="https://wprediscache.com/?utm_source=wp-plugin&amp;utm_medium=settings">
                <?php _e( 'Learn more', 'redis-cache' ); ?>
            </a>
        </p>
    </div>

</div>
