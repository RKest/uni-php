{
  description = "A very basic flake";

  inputs = {
    nixpkgs.url = "github:nixos/nixpkgs?ref=nixos-unstable";
  };

  outputs = { self, nixpkgs }:
  let
    system = "x86_64-linux";
    pkgs = nixpkgs.legacyPackages.${system};

    mysql_datadir = "./mysql_data";
    mysql_socket = "/tmp/mysql.sock";
    mysql_pid_file = "/tmp/mysql.pid";

    init_script = pkgs.writeScriptBin "init_mysql" ''
      #!${pkgs.stdenv.shell}

      if [ ! -d "${mysql_datadir}" ]; then
        echo "Initializing MySQL data directory..."
        mkdir -p ${mysql_datadir}
        ${pkgs.mysql84}/bin/mysqld --initialize-insecure \
          --datadir=${mysql_datadir} \
          --user=$(whoami)
      fi
    '';

    start_script = pkgs.writeScriptBin "start_mysql" ''
      #!${pkgs.stdenv.shell}

      if [ ! -S "${mysql_socket}" ]; then
        echo "Starting MySQL server..."
        ${pkgs.mysql84}/bin/mysqld \
          --datadir=${mysql_datadir} \
          --socket=${mysql_socket} \
          --pid-file=${mysql_pid_file} \
          --user=$(whoami) &

        # Wait for MySQL to start
        until [ -s "${mysql_socket}" ]; do
          sleep 1
        done
        echo "MySQL server started"
      else
        echo "MySQL server is already running"
      fi
    '';

    stop_script = pkgs.writeScriptBin "stop_mysql" ''
      #!${pkgs.stdenv.shell}

      if [ -f "${mysql_pid_file}" ]; then
        echo "Stopping MySQL server"
        kill $(cat ${mysql_pid_file})
        rm -f ${mysql_pid_file}
        rm -f ${mysql_socket}
        echo "MySQL server stopped"
      else
        echo "MySQL server not running"
      fi
    '';

    set_password = pkgs.writeScriptBin "set_mysql_passwd" ''
      #!${pkgs.stdenv.shell}

      set -eu
      
      mysql -u root -e "ALTER USER 'root'@'localhost' IDENTIFIED BY '$MYSQL_PASSWD'" > /dev/null 2>&1
    '';
  in
  {
    devShells.${system}.default = pkgs.mkShell {
      name = "multi-php";
      nativeBuildInputs = [pkgs.phpactor pkgs.emmet-language-server];
      buildInputs = [pkgs.php pkgs.mysql84 init_script start_script stop_script set_password];

      shellHook = ''
        export MYSQL_UNIX_PORT=${mysql_socket}
        init_mysql && start_mysql && echo 'MySQL ready, connect with: mysql -u root -p$MYSQL_PASSWD' || echo "Error starting mysql server"
        set_mysql_passwd && echo "MySQL password set successfully" || echo "MySQL password was already set"
      '';
    };
  };
}
