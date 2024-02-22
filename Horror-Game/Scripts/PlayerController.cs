using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class PlayerController : MonoBehaviour
{
    //  ステータス  //
    public float movespeed = 10;  //歩く速度
    public float dashSpeed = 20;  //走る速度
    public float jumpForce = 5;  //跳躍力
    public float maxSpeed;  //移動速度の最大速度
    //  物理判定  //
    private Rigidbody rb;   //プレイヤーの物理判定
    public bool canMove;  //ture:プレイヤーの操作が可能　false:プレイヤーの操作が不可能
    public Animator cameraAnime;  //カメラのアニメーション
    //  Move関数  //
    private AudioSource moveAudio;  //移動時の効果音
    private bool useMoveAudio;  
    private Vector3 moveForward_x;    //カメラの正面を軸に前後の移動を行う
    private Vector3 moveForward_z;    //カメラの正面を軸に左右の移動を行う
    private float speed;  //プレイヤーの移動速度を格納する

    //[SerializeField] private float limitSlope = 45;  //最高角度
    private bool walkKey1;  //WキーかSキーが押された時「true」、離された時「false」
    private bool walkKey2;  //AキーかDキーが押された時「true」、離された時「false」
    //  Rotate関数  //
    private float mouse_x;    //マウスの横の移動量を格納
    private float mouse_y;    //マウスの縦の移動量を格納
    [SerializeField] private float rotateSpeed = 2;    //体の回転の速度

    //  Dash関数  //
    private bool canDash;  //true:ダッシュが可能　false:ダッシュが不可能
    public bool useDash = true;  //true:ダッシュスライダーが減少　false:ダッシュスライダーが減少しない
    public Slider dashSlider;  //ダッシュできる時間を示すUIを格納
    //  Jump関数  //
    private bool canJump;  //true:ジャンプが可能　false:ジャンプが不可能
    private Ray jumpRay;  //地面と接触している間のみ「canJump」をtrueにする
    //  Crouch関数  //
    private bool canCrouch;  //true:しゃがみが可能　false:しゃがみが不可能
    public bool crouchFlag;  //true:しゃがんでいる状態　false:しゃがんでいない状態
    //  Slope関数  //
    private float getSlope;  //傾斜の角度
    private bool canSlope;  //true:坂を登ったり、下ったりする　false:坂の上に留まる
    private Ray slopeRay;  //坂の角度を取得する
    float posi_be;  //前フレームでのプレイヤーの位置
    float posi_af;  //現フレームでのプレイヤーの位置

    //  RoomName関数  //
    public Text roomNameText;
    //体力バー//
    public Slider lifeSlider;  //プレイヤーの体力を示すUIを格納

    void Start()
    {
        moveAudio = GetComponent<AudioSource>();
        speed = movespeed * 3;
        maxSpeed = movespeed;
        rb = GetComponent<Rigidbody>();
        canMove = false;  
    }

    void Update()
    {
        if (canMove)
        {
            Rotate();
            Dash();
            Jump();
            Crouch();
            Slope();
        }
        //Room();
    }
    private void FixedUpdate()
    {
        if (canMove) Move();  //移動関数
    }
    public void Rotate()  //回転関数
    {
        mouse_x = Input.GetAxis("Mouse X");
        Vector3 playerRotate = transform.localEulerAngles;
        playerRotate.y -= mouse_x * -rotateSpeed;
        transform.localEulerAngles = playerRotate;

    }
    public void Move()  //移動関数
    {

        if (canMove)
        {
            moveForward_z = Vector3.Scale(Camera.main.transform.forward, new Vector3(1, 0, 1)).normalized;
            moveForward_x = Vector3.Scale(Camera.main.transform.right, new Vector3(1, 0, 1)).normalized;
        }

        if (Input.GetKey(KeyCode.W))
        {
            rb.AddForce(moveForward_z * speed);  //前方に移動
        }
        if (Input.GetKey(KeyCode.S)) rb.AddForce(moveForward_z * -speed);  //後方に移動

        if (Input.GetKey(KeyCode.D)) rb.AddForce(moveForward_x * speed);  //右方に移動

        if (Input.GetKey(KeyCode.A)) rb.AddForce(moveForward_x * -speed);  //左方に移動

        if (rb.velocity.magnitude > maxSpeed) rb.velocity = rb.velocity.normalized * maxSpeed;  //移動速度の最大速度を超えないようにする

    }
    public void Dash()  //ダッシュ関数
    {
        if ((Input.GetKey(KeyCode.W) || Input.GetKey(KeyCode.S)) && Input.GetKey(KeyCode.LeftShift))
        {
            canDash = true;
            cameraAnime.speed = 2;
            if (Input.GetKey(KeyCode.W) && useDash) dashSlider.value -= 0.125f;
            if (Input.GetKey(KeyCode.S) && useDash) dashSlider.value -= 0.25f;
            if (dashSlider.value == 0)
            {
                canDash = false;
                cameraAnime.speed = 1;
            }
        }
        else if (Input.GetKeyUp(KeyCode.LeftShift))
        {
            canDash = false;
            cameraAnime.speed = 1;
        }
        if (canDash)
        {
            speed = dashSpeed * 2;
            maxSpeed = dashSpeed;

        }
        else if (canDash == false)
        {
            speed = movespeed * 2;
            maxSpeed = movespeed;
            dashSlider.value += 0.4f;
        }
    }
    public void Jump()  //ジャンプ関数
    {
        jumpRay = new Ray(transform.position, Vector3.down);
        RaycastHit jumpHit;
        Physics.Raycast(jumpRay, out jumpHit, 1.5f);  //()の第一引数にRayの名前、第二引数に情報を入れる変数名、第三引数にRayの長さ　　　※「out」を付けることでhitに戻り値を取得できる
        if (jumpHit.collider) canJump = true;
        else canJump = false;

        if (canJump && canCrouch == false && Input.GetKeyDown(KeyCode.Space))
        {
            canJump = false;
            rb.AddForce(Vector3.up * jumpForce, ForceMode.Impulse);
        }
    }
    public void Crouch()  //しゃがむ関数
    {

        if (Input.GetKeyDown(KeyCode.F))
        {
            canCrouch = !canCrouch;
        }
        if (canCrouch)
        {
            Camera.main.transform.position = new Vector3(Camera.main.transform.position.x, 0.5f, Camera.main.transform.position.z);
            GetComponent<CapsuleCollider>().height = 1;
            rb.drag = 5;
            crouchFlag = true;
            canJump = false;
        }
        else
        {
            Camera.main.transform.position = new Vector3(Camera.main.transform.position.x, 2.5f, Camera.main.transform.position.z);
            GetComponent<CapsuleCollider>().height = 1.7f;
            rb.drag = 2;
            crouchFlag = false;
            canJump = true;
        }

    }
    public void Slope()  //斜面関数
    {
        if (Input.GetKey(KeyCode.W) || Input.GetKey(KeyCode.S))
        {
            canSlope = true;
            walkKey1 = true;
            cameraAnime.SetBool("Move", walkKey1);
        }
        if (Input.GetKey(KeyCode.A) || Input.GetKey(KeyCode.D))
        {
            canSlope = true;
            walkKey2 = true;
            cameraAnime.SetBool("Move", walkKey2);
        }
        if (Input.GetKeyUp(KeyCode.W) || Input.GetKeyUp(KeyCode.S))
        {
            canSlope = false;
            walkKey1 = false;
            cameraAnime.SetBool("Move", walkKey1);
        }
        if (Input.GetKeyUp(KeyCode.A) || Input.GetKeyUp(KeyCode.D))
        {
            canSlope = false;
            walkKey2 = false;
            cameraAnime.SetBool("Move", walkKey2);
        }
        if (Input.GetKeyUp(KeyCode.W) || Input.GetKeyUp(KeyCode.A) || Input.GetKeyUp(KeyCode.S) || Input.GetKeyUp(KeyCode.D))
        {
            if (canJump && walkKey1 == false && walkKey2 == false) rb.velocity = Vector3.zero;
        }
        posi_af = transform.position.y;

        slopeRay = new Ray(transform.position, Vector3.down);
        RaycastHit slopeHit;
        Physics.Raycast(slopeRay, out slopeHit, 1.25f);  //()の第一引数にRayの名前、第二引数に情報を入れる変数名、第三引数にRayの長さ　　　※「out」を付けることでhitに戻り値を取得できる
        getSlope = Vector3.Angle(Vector3.up, slopeHit.normal);
        if (getSlope > 0 && canSlope == false)
        {
            rb.velocity = Vector3.zero;
        }
        else if (getSlope > 0 && canSlope)
        {
            if (posi_af < posi_be)
            {
                rb.AddForce(Vector3.up * -12f);
            }
            else rb.AddForce(Vector3.up * 6f);

        }
        posi_be = transform.position.y;
    }
}